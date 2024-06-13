<?php

namespace App\Http\Controllers;

use App\Models\Email;
use DateTime;
use Google\Client;
use Google\Service\Gmail;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class GmailController extends Controller
{
    public function index(Request $request)
    {
        // Check if access token exists in session
        if (!$request->session()->has('access_token')) {
            // Redirect to authentication endpoint if access token is missing
            return redirect()->route('auth.callback');
        }

        // Retrieve access token from session
        $accessToken = $request->session()->get('access_token');

        // Initialize Google Client
        $client = new Client();
        $client->setAccessToken($accessToken);

        // Initialize Gmail service
        $service = new Gmail($client);

        // Fetch emails from Gmail inbox
        try {
            $messages = $service->users_messages->listUsersMessages('me');

            $emails = [];
            foreach ($messages->getMessages() as $message) {
                $email = $service->users_messages->get('me', $message->getId());
                $messageData = $email->getPayload()->getHeaders();

                $sen = $this->getHeaderValue($messageData, 'From');
                $sender = $sender = preg_match('/<(.*?)>/', $sen, $matches) ? $matches[1] : $sen; 
                $subject = $this->getHeaderValue($messageData, 'Subject');
                $body = $this->decodeMessageBody($email->getPayload());
                $receivedDate = $this->getHeaderValue($messageData, 'Date');
                $dateTime = DateTime::createFromFormat('D, d M Y H:i:s O', $receivedDate);
                $formattedDate = $dateTime->format('Y-m-d');

                if ($subject === "Demande de Rendez-vous") {
                    $existingEmail = Email::where('body', $body)->first();
                    // If no email with the same body exists, save the new email
                    if (!$existingEmail) {
                        $email = new Email();
                        $email->sender = $sender;
                        $email->subject = $subject;
                        $email->body = $body;
                        $email->received_date = $formattedDate;
                        $email->save();
                    }
                }
            }
            
            $allEmails = Email::orderBy('received_date', 'desc')->get();
            

            
            $page = $request->input('page', 1); // Get the current page from the request, default to 1
            $perPage = 10; // Number of emails per page
            $total = count($allEmails); // Total number of emails
            $emails = $allEmails->slice(($page - 1) * $perPage, $perPage); // Slice the emails for the current page

            $emails = new LengthAwarePaginator($emails, $total, $perPage, $page, [
                'path' => $request->url(), // URL path for pagination links
                'query' => $request->query(), // Query parameters for pagination links
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
        
        return view('emails.index', compact('emails'));
    }

    public function DateFilter(Request $request){
        $dateFilter = $request->input('date_filter');
        if ($dateFilter) {
            $allEmails = Email::whereDate('received_date', $dateFilter)->orderBy('received_date', 'desc')->get();
            $page = $request->input('page', 1); // Get the current page from the request, default to 1
            $perPage = 10; // Number of emails per page
            $total = count($allEmails); // Total number of emails
            $emails = $allEmails->slice(($page - 1) * $perPage, $perPage); // Slice the emails for the current page

            $emails = new LengthAwarePaginator($emails, $total, $perPage, $page, [
                'path' => $request->url(), // URL path for pagination links
                'query' => $request->query(), // Query parameters for pagination links
            ]);
            return view('emails.index', compact('emails'));
        }
        
    }


    private function getHeaderValue($headers, $headerName)
    {
        foreach ($headers as $header) {
            if ($header->name == $headerName) {
                return $header->value;
            }
        }
        return null;
    }

    private function decodeMessageBody($payload)
    {
        if ($payload->getBody()->getSize() > 0) {
            return base64_decode(strtr($payload->getBody()->getData(), '-_', '+/'));
        } elseif ($payload->getParts() && count($payload->getParts()) > 0) {
            foreach ($payload->getParts() as $part) {
                if ($part->getBody()->getSize() > 0) {
                    return base64_decode(strtr($part->getBody()->getData(), '-_', '+/'));
                }
            }
        }
        return null;
    }
}

