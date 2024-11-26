<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page - Public Attorney's Office</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./customcss/custom.css" />
    <style>
        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 1rem;
        }

        .carousel-item img {
            height: auto;
            object-fit: cover;
            /* Ensure the image covers the container */
        }

        .navbar-brand img {
            height: 40px;
            /* Adjust the height of the logo as needed */
            margin-right: 10px;
            /* Space between the logo and the text */
        }
    </style>
</head>

<body class="generalbg">
    <!-- Navbar with Login Button -->
    <nav class="navbar navbar-expand-lg navbar-light generalbg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/pao.png') }}" alt="Logo"> <!-- Path to your logo -->
                Public Attorney's Office
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-success sideback" style="background-color: #0D9488;" href="/app">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carousel -->
    <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/pao2.jpg') }}" class="d-block w-100" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to Our Site</h5>
                    <p>Experience the best services with us.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/attorney2.jpg') }}" class="d-block w-100" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Discover Our Features</h5>
                    <p>Explore the wide range of features we offer.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/consultation2.jpg') }}" class="d-block w-100" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Join Us Today</h5>
                    <p>Become a part of our community now.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- About Us Section -->
    <section class="py-5 text-center generalbg">
        <div class="container">
            <h2>About Us</h2>
            <p class="lead">We are committed to providing the best service. Our team is dedicated to making sure your
                experience with us is excellent. Learn more about our values and what drives us forward.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-green-500 text-white py-4" style="background-color: #0D9488;">
        <div class="container mx-auto text-center">
            <div class="flex flex-col items-center">
                <h5 class="text-xl font-semibold mb-2">Legal Information</h5>
                <p class="mb-2">&copy; 2024 Public Attorney's Office. All rights reserved.</p>
                <p>
                    <a href="#" class="text-white hover:text-gray-200">Privacy Policy</a> |
                    <a href="#" class="text-white hover:text-gray-200">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
