<!DOCTYPE html>
<html lang="en">
<head>
	@include('home.css')
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    
   @include('home.header')

    <!--  About Section  -->
    @include('home.about')

    <!--  gallary Section  -->
    @include('home.gallery')

    <!-- book a table Section  -->
    @include('home.book')

    @include('home.blog')
   

    @include('home.footer')

</body>
</html>
