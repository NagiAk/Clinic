@extends('layout')

@section('content')
<style>

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.8s ease-out, transform 0.9s ease-out;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .hero, .services, .doctors{
        background-color: rgba(153, 224, 197, 0.336);
        color: black;
    }
    .inf{
        background: linear-gradient(110deg, #8bbbbb70 50%, #edf8ef 50%);

    }

</style>
<div class="hero fade-in">
    <h1>Your doctor is here</h1>
    <p>Circle Clinic is a modern clinic for complex operations and emergency care in the center of Fes. We have been providing all types of emergency medical care to our patients since 2024.</p>
    <img src="doc.jpg" alt="Meet Our Doctors" style="width: 300px; height: 200px;">
</div>

<div class="container services fade-in">
    <h2 class="section-title">Why choose Circle Clinic?</h2>
    <div class="row">
        <div class="col-md-5 card inf">
            <h3 class="card-title">Successful treatment</h3>
            <p class="card-text">Our experience of treating millions of patients each year prepares us to take care of the one who matters most - you.</p>
        </div>
        <div class="col-md-5 card inf">
            <h3 class="card-title">Best experience</h3>
            <p class="card-text">We employ the best specialists. Would you like to get to know our employees?</p>
        </div>
        <div class="col-md-5 card inf">
            <h3 class="card-title">Our Clinic</h3>
            <p class="card-text">We provide a comfortable and welcoming environment for all our patients. Visit us to experience our top-notch facilities and services.</p>
        </div>
        <div class="col-md-5 card inf">
            <h3 class="card-title">All answers</h3>
            <p class="card-text">Count on our experts to deliver an accurate diagnosis and the right plan for you the first time.</p>
        </div>
    </div>
</div>

<div class="container doctors fade-in">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="cardd">
                    <img src="services.jpg" class="card-img-top custom-img-size" alt="Our Services">
                    <div class="card-body">
                        <h5 class="card-title">Our Services</h5>
                        <p class="card-text">We offer a wide range of medical services to meet your needs.</p>
                        <a href="{{ route('services.index') }}" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cardd">
                    <img src="doc.jpg" class="card-img-top custom-img-size" alt="Meet Our Doctors">
                    <div class="card-body">
                        <h5 class="card-title">Meet Our Doctors</h5>
                        <p class="card-text">Our experienced and compassionate doctors are here to help you.</p>
                        <a href="{{ route('doctors.index') }}" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cardd">
                    <img src="contact.jpg" class="card-img-top custom-img-size" alt="Contact Us">
                    <div class="card-body">
                        <h5 class="card-title">Contact Us</h5>
                        <p class="card-text">Get in touch with us for any queries or to schedule an appointment.</p>
                        <a href="{{ route('contact.index') }}" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const elements = document.querySelectorAll('.fade-in');
        elements.forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endsection
