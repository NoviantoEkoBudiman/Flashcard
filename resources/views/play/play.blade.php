@extends('index')

@section('main')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    .container{
        transform-style: preserve-3d;
    }

    .container .box{
        position: relative;
        width: 300px;
        height: 300px;
        margin: 20px;
        transform-style: preserve-3d;
        perspective: 1000px;
        cursor: pointer;
    }

    .container .box .body{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transform-style: preserve-3d;
        transition: 0.9s ease;
    }

    /* FRONT / QUESTION */
    .container .box .body .imgContainer{
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        transform-style: preserve-3d;
        background-image: linear-gradient(to bottom right, #00C0FF, #4218B8);
        padding: 20px;
        overflow: hidden;          /* cegah overflow */
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .container .box .body .imgContainer img{
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
    }

    /* BACK / ANSWER */
    .container .box .body .content{
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        backface-visibility: hidden;
        transform-style: preserve-3d;
        transform: rotateY(180deg);
        border-radius: 8px;

        /* padding & layout supaya konten memenuhi kartu */
        padding: 20px;
        display: flex;
        flex-direction: column;

        /* pakai gradient seperti sisi depan */
        background-image: linear-gradient(to bottom right, #0100EC, #FB36F4);
    }

    .container .box:hover .body{
        transform: rotateY(180deg);
    }

    /* Bungkus judul + isi jawaban */
    .answer-wrap{
        display: flex;
        flex-direction: column;
        gap: 8px;
        height: 100%;          /* penuhi tinggi kartu */
    }

    /* Anti-overflow teks umum */
    .card-text-wrap{
        word-break: break-word;
        overflow-wrap: anywhere;
        margin: 0;
    }

    /* Teks pertanyaan dibatasi agar rapi */
    .front-text{
        /* pilih salah satu: clamp baris atau scroll */
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 8;
        overflow: hidden;
        line-height: 1.4;
        font-size: clamp(0.95rem, 2.4vw, 1.05rem);
        color: #fff;
    }

    /* Teks jawaban mengisi ruang tersisa */
    .answer-text{
        flex: 1;
        overflow: auto;
        line-height: 1.35;
        font-size: clamp(2rem, 4vw, 2rem); /* ← Dulu 1rem–1.35rem, sekarang naik */
        color: #fff;
    }

    .answer-title{ font-size: 1.1rem; color:#fff; }
</style>

<div class="container d-flex align-items-center justify-content-center flex-wrap">
    @if($card)
        <div class="d-flex flex-column align-items-center">
            <!-- Cards left -->
            <div class="d-flex justify-content-center align-items-center mb-3 w-100">
                <span class="text-center">Cards left: {{ $left }}</span>
            </div>

            <!-- Kartu tanya/jawab -->
            <div class="box">
                <div class="body">
                    @php
                        // Ambil jawaban lalu sisipkan <br> sebelum "(" pertama
                        $ans = $card->cards_answer ?? '';
                        $ans = preg_replace('/\s*\(/', '<br>(', $ans, 1);
                        $answerFirst = $playMode === 'answer-first';
                    @endphp

                    <!-- Front -->
                    <div class="imgContainer">
                        <h3 class="text-white fs-5 mb-1">{{ $answerFirst ? 'Answer' : 'Question' }}</h3>
                        @if($answerFirst)
                            <div class="card-text-wrap answer-text">{!! $ans !!}</div>
                        @else
                            <p class="card-text-wrap front-text">{{ $card->cards_question }}</p>
                        @endif
                    </div>

                    <!-- Back -->
                    <div class="content">
                        <div class="answer-wrap">
                            <h3 class="answer-title mb-1">{{ $answerFirst ? 'Question' : 'Answer' }}</h3>
                            @if($answerFirst)
                                <p class="card-text-wrap front-text">{{ $card->cards_question }}</p>
                            @else
                                <div class="card-text-wrap answer-text">{!! $ans !!}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center">
            Congratulation, you've finished the game!<br/>
            <a href="{{ route('replay', ['categories_id' => Request::segment(2), 'language_id' => session('language_id'), 'mode' => $playMode]) }}" type="button" class="btn btn-outline-danger">Replay</a>
            <a href="{{ url('finish/'.Request::segment(2).'/'.session('language_id')) }}" type="button" class="btn btn-outline-primary">Finish</a>
        </div>
    @endif
</div>

<br>

@if($card)
    <div class="container bg-light">
        <div class="col-md-12 text-center">
            <a href="{{ route('next', ['id_category' => Request::segment(2), 'id_language' => $card->cards_id, 'mode' => $playMode]) }}" type="button" class="btn btn-outline-primary">Next</a>
        </div>
    </div>
@endif
@endsection
