@extends('boilerplate')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">

            @if(isset($errors) and count($errors))

                <h2 style="color: red;">Potrditev registracije ni uspela</h2>
                <br>
                <br>
                <p><b>Razlog:</b> {{ $errors->first() }}</p>
                <br>
                <br>
                <div class="links">
                    @if(array_key_exists('verification_expires', $errors->messages()))
                        <a href="#">Ponovno pošlji potrditveni email</a>
                    @endif
                    <a href="{{  env('APP_URL') }}">Domača stran</a>
                </div>
            @else
                <h2 style="color: lightgreen">Pozdravljeni, {{ $email }}. Uspešno ste potrdili svojo registracijo! </h2>
                <br>
                <br>
                <div class="links">
                    <a href="{{  env('APP_URL') }}">Domača stran</a>
                </div>
            @endif

        </div>
    </div>
@endsection

