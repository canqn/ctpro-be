@extends('layouts.user')

@section('title', 'CTPro -Ứng Dụng Quản Lý Hoá Đơn Điện Tử')

@section('contents')
{{--  --}}

<main>
 <!-- SEO Meta Tags -->
    <meta name="description" content="CTPro là công cụ hỗ trợ tải hóa đơn PDF/XML hàng loạt, kết xuất bảng kê chi tiết và chuyển đổi dữ liệu sang các phần mềm kế toán phổ biến.">
    <meta name="keywords" content="CTPro, quản lý hóa đơn, tải hóa đơn PDF, tải hóa đơn XML, kế toán, tiết kiệm thời gian, chuyển đổi dữ liệu">
    <link rel="canonical" href="{{ url()->current() }}">
    {{-- <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg h-96">
                Trang chủ
            </div>
        </div>
    </div> --}}
     <!--=============== HOME ===============-->
     <section class="home section pt-8 lg:pt-16 pb-5 px-4 lg:px-0" id="home">
        <div class="home__container container mx-auto lg:flex lg:justify-between lg:items-center gap-4">
            <div class="home__data lg:w-1/2 mb-5">
                <h1 class="home__title font-bold text-3xl lg:text-4xl mb-3">Ứng Dụng Quản Lý<br>
                    Và Xử Lý Hoá Đơn CTPro</h1>
                <p class="home__description mb-3">Công cụ hỗ trợ tải hóa đơn PDF/XML hàng loạt. Kết xuất bảng kê chi tiết hàng hóa ra Excel. Hỗ trợ kết xuất file import vào phần mềm kế toán phổ biến và còn nhiều chức năng khác...</p>
                <a href="https://www.youtube.com/watch?v=mke5k2Y7ILo" class="button home__button bg-yellow-400 hover:bg-yellow-300 px-3 py-2 rounded-lg text-black font-medium ">Xem video Hướng Dẫn</a>
            </div>
            <div class="home__image lg:w-1/2">
                <img class="w-full h-auto" src="{{ asset('assets/images/app3.jpg') }}" alt="">
            </div>
        </div>
    </section>
    <!--=============== SERVICES ===============-->
    <section class="container services mt-5 mx-3" id="services">
        <h3 class="text-3xl text-center font-bold mb-3">CÔNG CỤ MIỄN PHÍ</h3>
        <p class="text-xl text-center">Dùng CTPro để tiết kiệm thời gian của bạn</p>
        <div class="services__container mt-5 grid lg:grid-cols-3 gap-8 md:grid-cols-2 sm:grid-cols-1 sm:mx-3">
            <div class="services__data p-4 rounded-lg border border-gray-300 hover:shadow-lg transition-all duration-300 ">
                <div class="flex flex-col items-center mb-2">
                    <h3 class="services__subtitle font-bold text-center">Tải hoá đơn PDF/XML hàng loạt</h3>
                    <i class='bx bxs-file-find text-6xl text-yellow-500 my-2'></i>
                    <p class="services__description text-center mb-4">Dễ dàng tải hàng loạt hoá đơn dưới định dạng PDF hoặc XML để quản lý và lưu trữ một cách hiệu quả.</p>
                </div>
            </div>
            <div class="services__data p-4 rounded-lg border border-gray-300 hover:shadow-lg transition-all duration-300">
                <div class="flex flex-col items-center mb-2">
                    <h3 class="services__subtitle font-bold text-center">Công cụ tải hoá đơn gốc pdf</h3>
                    <i class='bx bxs-file-pdf text-6xl text-red-500 my-2'></i>
                    <p class="services__description text-center mb-4">Nhanh chóng tải hoá đơn gốc dưới định dạng PDF từ các nhà cung cấp và lưu trữ chúng một cách an toàn.</p>
                </div>
            </div>
            <div class="services__data p-4 rounded-lg border border-gray-300 hover:shadow-lg transition-all duration-300">
                <div class="flex flex-col items-center mb-2">
                    <h3 class="services__subtitle font-bold text-center">Chuyển đổi dữ liệu sang các phần mềm kế toán</h3>
                    <i class='bx bx-transfer text-6xl text-blue-500 my-2'></i>
                    <p class="services__description text-center mb-4">Dễ dàng chuyển đổi và tích hợp dữ liệu vào các phần mềm kế toán phổ biến, tiết kiệm thời gian và giảm thiểu lỗi.</p>
                </div>
            </div>
        </div>
    </section>
    <!--=============== APP ===============-->
    <section class="app section mt-9">
        <div class="max-w-4xl mx-auto text-center mb-12">
        <h3 class="text-3xl font-bold mb-3 text-gray-800">Tại sao CTPro là lựa chọn hàng đầu?</h3>
        <p class="text-lg text-gray-600">
            CTPro là một trợ lí đắc lực với mọi kế toán văn phòng. Thao tác đơn giản, chỉ cần 1 vài click chuột là xử lý lượng dữ liệu lớn, giúp tiết kiệm hàng nghìn giờ cho mọi người.
        </p>
        </div>

        <div class="app__container grid md:grid-cols-2 gap-8 items-center mx-auto max-w-6xl py-16 px-4">
        <div class="app__data">
            <h3 class="section__title-center text-3xl md:text-4xl font-bold mb-4 md:mb-6 text-gray-800">Nhanh chóng và Miễn phí</h3>
            <p class="app__description text-base md:text-lg text-gray-600 mb-6 md:mb-8">
            Bạn chỉ cần vài click chuột, việc còn lại được CTPro xử lý. Tất cả chỉ diễn ra trong vòng vài giây.
            </p>
            <div class="app__buttons flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <a href="#" class="button button-flex app__button bg-blue-500 text-white px-6 md:px-8 py-3 md:py-4 rounded-lg md:rounded-full flex items-center justify-center space-x-2 hover:bg-blue-600 transition-colors duration-300 shadow-lg">
                <i class='bx bxl-support text-2xl md:text-3xl'></i>
                <span class="font-semibold">Liên hệ ngay</span>
            </a>
            </div>
        </div>
        <div class="app__image">
            <img src="{{ asset('assets/images/app1.jpg') }}" alt="Description of the image" class="rounded-xl shadow-2xl">
        </div>
        </div>

        {{-- app2 --}}
        <div class="app__container grid md:grid-cols-2 gap-8 items-center mx-auto max-w-6xl py-16 px-4">
        <div class="app__image order-2 md:order-1">
            <img src="{{ asset('assets/images/app2.jpg') }}" alt="Description of the image" class="rounded-xl shadow-2xl">
        </div>
        <div class="app__data order-1 md:order-2">
            <h3 class="section__title-center text-3xl md:text-4xl font-bold mb-4 md:mb-6 text-gray-800">Tiết kiệm thời gian và Công sức</h3>
            <p class="app__description text-base md:text-lg text-gray-600 mb-6 md:mb-8">
            Với CTPro, bạn có thể tập trung vào các công việc quan trọng khác trong khi chúng tôi xử lý dữ liệu của bạn một cách nhanh chóng và hiệu quả.
            </p>
        </div>
        </div>
    </section>

    <section class="lienhe">
        <div class=" py-16">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
              <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Tư vấn miễn phí
              </h2>
              <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                Đội ngũ chuyên gia của chúng tôi sẵn sàng giải đáp mọi thắc mắc và tư vấn giải pháp phù hợp nhất cho bạn.
              </p>
            </div>
            <div class="mt-10">
              <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                <div class="relative">
                  <dt>
                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                      </svg>
                    </div>
                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">
                      Tư vấn qua điện thoại
                    </p>
                  </dt>
                  <dd class="mt-2 ml-16 text-base text-gray-500">
                    Gọi cho chúng tôi để được tư vấn trực tiếp.<br />
                    Hotline: <a href="tel:0914659519" class="text-indigo-600 hover:text-indigo-900">0914.659.519 - 0326.168.326</a>
                  </dd>
                </div>
                <div class="relative">
                  <dt>
                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                      </svg>
                    </div>
                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">
                      Tư vấn qua chat
                    </p>
                  </dt>
                  <dd class="mt-2 ml-16 text-base text-gray-500">
                    Trò chuyện trực tuyến với chuyên gia của chúng tôi để nhận tư vấn.<br />
                    Email: <a href="mailto:nvcqnn@gmail.com" class="text-indigo-600 hover:text-indigo-900">nvcqnn@gmail.com</a>
                  </dd>
                </div>
              </dl>
              <div class="mt-10 text-center">
                <p class="text-lg font-medium text-gray-900">Hoặc liên hệ với chúng tôi qua Zalo:</p>
                <div class=" flex justify-center gap-5">
                    <img class=" w-24 h-24" src="{{ asset('assets/images/zalo1.png') }}" alt="QR Code Zalo" class="mx-auto mt-4">
                    <img  class=" w-24 h-24" src="{{ asset('assets/images/zalo2.png') }}" alt="QR Code Zalo" class="mx-auto mt-4">
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>

    {{-- Bảng giá --}}

</main>
@endsection
