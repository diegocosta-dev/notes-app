@extends('layouts.main_layout')

@section('content')
    <div class="container mt-5">
        @if (session('successLogin'))
            <div class="alert alert-success mt-3">
                {{ session('successLogin') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col">

                @include('components.top_bar')
                
                @if (count($notes) != 0)
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('add.note') }}" class="btn btn-secondary px-3">
                            <i class="fa-regular fa-pen-to-square me-2"></i>New Note
                        </a>
                    </div>

                    @foreach ($notes as $note)
                        @include('components.note_card')
                    @endforeach
                @else
                    <div class="row mt-5">
                        <div class="col text-center">
                            <p class="display-6 mb-5 text-secondary opacity-50">You have no notes available!</p>
                            <a href="{{ route('add.note') }}" class="btn btn-secondary btn-lg p-3 px-5">
                                <i class="fa-regular fa-pen-to-square me-3"></i>Create Your First Note
                            </a>
                        </div>
                    </div>

                    <hr class="my-5">
                @endif                
            </div>
        </div>
    </div>
@endsection
