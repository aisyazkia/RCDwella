@extends('layouts.home.index')
@section('content')
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <h1>Welcome to RC Dwella</h1>
      <h2>Rumah Cantik Dwella merupakan klinik yang dikhususkan untuk melayani
        perawatan wajah seperti facial, mikrodermabrasi, mesotherapy, chemical peeling, 
        dan yang lainnya</h2>

    </div>
  </section>
  <!-- End Hero -->

  <main id="main">

    <!-- ======= Services Section ======= -->
    <section id="treatment" class="services">
      <div class="container">
        <div class="section-title">
          <h2>Treatments</h2>
        </div>
        <div class="row">
          @foreach ($treatments as $item)
            <div class="col-sm-6 col-md-4 col-xl-4 d-flex align-items-stretch mb-4">
              <div class="icon-box mt-4 mt-xl-0 w-100">
                <i class="fas fa-heartbeat"></i><br><br>
                <h4>{{ $item->name }}</h4>
                <p>{{ $item->description }}</p>
              </div>
            </div> 
          @endforeach 
      </div>
    </section>
    <!-- End Services Section -->
    <!-- ======= Departments Section ======= -->
    <section id="about-us" class="departments">
      <div class="container">
        <div class="section-title">
          <h2>Tentang Dwella</h2>
        </div>
        <div class="row gy-4">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show px-2" data-bs-toggle="tab" href="#tab-1">Deskripsi</a>
              </li>
              <li class="nav-item">
                <a class="nav-link px-2" data-bs-toggle="tab" href="#tab-2">Penghargaan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link px-2" data-bs-toggle="tab" href="#tab-3">Pengalaman Kerja</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9">
            <div class="tab-content">
              <div class="tab-pane active show" id="tab-1">
                <div class="row gy-4">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Deskripsi</h3>
                    <p>Rumah Cantik Dwella merupakan salon kecantikan yang dikhususkan untuk melayani
                      perawatan wajah seperti facial, mikrodermabrasi, mesotherapy, chemical peeling, 
                      dan yang lainnya. RC Dwella menawarkan harga yang lebih terjangkau dengan penanganan treatment yang dilakukan oleh ahlinya.</p></div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="img/icon-dwella.png" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-2">
                <div class="row gy-4">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Penghargaan</h3>
                    <p>RC Dwella sudah memiliki sertifikat uji kompetensi BNSP yang sudah diakui se Asia Tenggara </p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="img/serifikat-penghargaan.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-3">
                <div class="row gy-4">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Pengalaman Kerja</h3>
                    <p>RC Dwella sudah banyak mengikuti pelatihan yang diselenggarakan oleh Novanka Beauty Centre, diantaranya ialah pelatihan estetika kulit dan kecantikan, pelatihan pembuatan serum wajah, pelatihan v-shape mummy mask, dan masih banyak lagi.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="img/pelatihan-serum-wajah.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </section><!-- End Departments Section -->
    
    <section id="contact" class="contact">
      <div class="container">
        
        <div class="section-title mb-3" id="lokasi">
          <h2>Lokasi</h2>
          <p>RC Dwella Taman Hayati Salam blok E.2, Jl Muchtar Raya Sawangan Baru Depok</p>
        </div>
        <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.966883839393!2d106.77112131477003!3d-6.398269095370455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf1560a387c141d9c!2zNsKwMjMnNTMuOCJTIDEwNsKwNDYnMjMuOSJF!5e0!3m2!1sid!2sid!4v1661003044574!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        {{-- <iframe style="border:0; width: 100%; height: 350px;"  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7929.916961475902!2d106.77297352883542!3d-6.3993518640089135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e97d827c9e4d%3A0x880ced87ca0c5964!2sPerumahan%20Taman%20Hayati%20Salam!5e0!3m2!1sid!2sid!4v1657383430911!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
      </div>
    </section>
    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container">

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            @foreach ($testimony as $testi)
              <div class="swiper-slide">
                <div class="testimonial-wrap">
                  <div class="testimonial-item">
                    <img src="{{ asset($testi->user->image) }}" class="testimonial-img" alt="">
                    <h3>{{ $testi->user->name }}</h3>
                    <h4>
                      @for ($i=0;$i<$testi->rating;$i++)
                        <i class="fa fa-star text-warning"></i>
                      @endfor
                    </h4>
                    <p>
                      <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                      {{ $testi->comment }}
                      <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                    </p>
                  </div>
                </div>
              </div>
            @endforeach

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section>

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
      <div class="container">

        <div class="section-title mb-3">
          <h2>Gallery</h2>
          </div>
      </div>

      <div class="container-fluid">
        <div class="row g-0">

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="img/gallery/galeri5.jpg" class="galelry-lightbox">
                <img src="img/gallery/galeri5.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="img/gallery/galeri4.jpg" class="galelry-lightbox">
                <img src="img/gallery/galeri4.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="img/gallery/galeri3.jpg" class="galelry-lightbox">
                <img src="img/gallery/galeri3.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="img/gallery/galeri9.jpg" class="galelry-lightbox">
                <img src="img/gallery/galeri9.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="img/gallery/galeri7.jpg" class="galelry-lightbox">
                <img src="img/gallery/galeri7.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="img/gallery/galeri8.jpg" class="galelry-lightbox">
                <img src="img/gallery/galeri8.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="img/gallery/galeri2.jpg" class="galelry-lightbox">
                <img src="img/gallery/galeri2.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="img/gallery/galeri6.jpg" class="galelry-lightbox">
                <img src="img/gallery/galeri6.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

        </div>

      </div>
    </section>

  </main><!-- End #main -->
@endsection