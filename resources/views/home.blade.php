<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            @include('partials._brand')
            <div class="d-flex align-items-center">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Sign In</a>
                @endauth
            </div>
        </div>
    </nav>
    <header class="container-fluid">
        <div class="row">
            <div class="col-6 left-col ps-4 pt-3 pb-3">
                <h1>Satisfy your pet's <span class="d-block">needs here at</span><span class="d-block">Arf & Meow
                        Co.</span></h1>
                <p>Get it here while supplies last!</p>
                <a href="">Shop now</a>
            </div>
            <div class="col-6 right-col position-relative">
                <img src="{{ asset('images/catty.png') }}" alt="Cat">
            </div>
        </div>
        <div class="row row-under">
            <div class="col-12 text-center fw-bold">
                <p>At Arf & Meow Co., we know pets are family — and they deserve the very best. Whether you have a
                    playful pup or a curious cat, our catalog is filled with quality supplies, handpicked to keep your
                    pets healthy, happy, and thriving. We’re more than just a store — we’re a community of animal
                    lovers. Explore our website to give your pet the life they deserve.</p>
            </div>
        </div>
    </header>
    <section class="container-fluid know-us text-center pb-5">
        <div class="row justify-content-end">
            <div class="col-6 me-2">
                <h2 class="pt-4 pt-3">Get to <span class="d-block">Know Us</span></h2>
                <p class="boi mt-3">Arf and Meow Co. is an all-natural and cruelty-free pet store that provides top
                    quality food, accessories, and grooming products for your pets.</p>
            </div>
        </div>
    </section>
    <section class="container-fluid product text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>Our <span class="d-block">Product Lines</span></h2>
            </div>
            <div class="col-6 col-lg-4">
                <img class="p-4" src="{{ asset('images/product_dog.png') }}" alt="Logo">
                <h3>Products For Dogs</h3>
                <p>Raise your dogs to be at their happiest and healthiest!</p>
            </div>
            <div class="col-6 col-lg-4">
                <img class="p-4" src="{{ asset('images/product_cat.png') }}" alt="Logo">
                <h3>Products For Cats</h3>
                <p>Premium products for your favorite feline companions</p>
            </div>
        </div>
    </section>
    <section class="container-fluid mt-4 pb-5 featured text-center">
        <div class="row justify-content-center gy-4">
            <h2 class="mt-4">Featured <span class="d-block">Products</span></h2>
            <div class="col-8 col-sm-6 col-lg-3 card g-4">
                <img class="p-4" src="{{ asset('images/turkey_hat.png') }}" alt="Featured Dog">
                <h3>Cat Turkey Hat</h3>
                <p class="desc mx-3">Dress your feline in festive flair with this adorable Turkey Hat for Cats!</p>
                <p class="price">P 190.00</p>
                <p class="stock">In Stock</p>
                <a class="mb-3 mx-auto" href="">Shop Now</a>
            </div>
            <div class="col-8 col-sm-6 col-lg-3 card g-4">
                <img class="p-4" src="{{ asset('images/fish_hat.png') }}" alt="Featured Dog">
                <h3>Cat Fish Hat</h3>
                <p class="desc mx-3">Turn your cat into the cutest catch of the day with this whimsical Fish Hat
                    for Cats!
                </p>
                <p class="price">P 190.00</p>
                <p class="stock">In Stock</p>
                <a class="mb-3 mx-auto" href="">Shop Now</a>
            </div>
            <div class="col-8 col-sm-6 col-lg-3 card g-4">
                <img class="p-4" src="{{ asset('images/tower_gray.png') }}" alt="Featured Dog">
                <h3>Cat Tower Gray</h3>
                <p class="desc mx-3">Give your cat the perfect space to rest and play with this durable Cat Tree!
                </p>
                <p class="price">P 7,000.00</p>
                <p class="stock">In Stock</p>
                <a class="mb-3 mx-auto" href="">Shop Now</a>
            </div>
            <div class="col-8 col-sm-6 col-lg-3 card g-4">
                <img class="p-4" src="{{ asset('images/sunglasses.png') }}" alt="Featured Dog">
                <h3>Stylish Pet Sunglasses</h3>
                <p class="desc mx-3">Keep your furry friend looking cool and protected with these Stylish Pet
                    Sunglasses!
                </p>
                <p class="price">P 180.00</p>
                <p class="stock">In Stock</p>
                <a class="mb-3 mx-auto" href="">Shop Now</a>
            </div>
        </div>
    </section>
    <section class="container-fluid">
        <div class="form">
            <h2 class="mb-3">For any concern, send us a message:</h2>
            <form action="" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email Address:</label>
                <input type="text" id="email" name="email" required>
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>
    <footer class="container-fluid mt-5">
        <div class="row justicy-content-space-between">
            <div class="col">
                <h2>Arf & Woof Co.</h2>
                <p class="credits">© Group 8 2025. All Rights Reserved</p>
            </div>
            <div class="col">
                <p class="connect mb-1">Connect With Us:</p>
                <div class="d-flex justify-content-end">
                    <a href="" class="mx-2"><img src="{{ asset('images/telephone.png') }}"
                            alt="Phone"></a>
                    <a href="" class="mx-2"><img src="{{ asset('images/fb.png') }}" alt="Facebook"></a>
                    <a href="" class="mx-2"><img src="{{ asset('images/ig.png') }}" alt="Instagram"></a>
                    <a href="" class="mx-2"><img src="{{ asset('images/mail.png') }}" alt="E-Mail"></a>
                    <a href="" class="mx-2"><img src="{{ asset('images/shopee.png') }}"
                            alt="Shopee"></a>
                    <a href="" class="mx-2"><img src="{{ asset('images/tik-tok.png') }}"
                            alt="Tiktok"></a>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/footer.png') }}" alt="Footer chuchu" class="img-fluid footer-img">
    </footer>

</body>

</html>
