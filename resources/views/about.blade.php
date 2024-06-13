@extends('layout')

@section('content')
<style>
    .content {
            margin: 0 auto;
            flex-grow: 1;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.349);
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
</style>
<div class="container content mt-5">
    <h1>About Us</h1>
        <p>Welcome to our clinic! We are dedicated to providing the best healthcare services to our community. Our team of experienced professionals is here to ensure you receive the highest quality care in a comfortable and welcoming environment.</p>

        <h2>Our Mission</h2>
        <p>Our mission is to improve the health and well-being of our patients by offering compassionate and comprehensive medical care. We strive to meet the unique needs of each individual and to foster a healthy community.</p>

        <h2>Our Team</h2>
        <p>Our clinic is staffed by a team of dedicated professionals who are passionate about healthcare. Our doctors, nurses, and administrative staff work together to provide exceptional service and support to our patients.</p>

        <h3>Dr. John Doe</h3>
        <p>Dr. John Doe is a board-certified physician with over 20 years of experience in family medicine. He is committed to providing personalized care to each of his patients.</p>

        <h3>Dr. Jane Smith</h3>
        <p>Dr. Jane Smith is a specialist in internal medicine with a focus on preventive care. She believes in the importance of early detection and treatment of health issues.</p>

        <h2>Our Services</h2>
        <p>We offer a wide range of medical services to meet the needs of our patients, including:</p>
        <ul>
            <li>General check-ups and physical exams</li>
            <li>Specialty care in various fields</li>
            <li>Preventive health screenings</li>
            <li>Chronic disease management</li>
            <li>Vaccinations and immunizations</li>
        </ul>
        <h4>Contact Us</h4>
        <p>If you have any questions or would like to learn more about our services, please do not hesitate to contact us.</p>
        <ul>
            <li>Email: contact@clinicproject.com</li>
            <li>Phone: +212 645856898</li>
            <li>Address: 123 Clinic </li>
        </ul>

        <p>Thank you for choosing our clinic for your healthcare needs. We look forward to serving you and helping you achieve your health goals.</p>
</div>
@endsection