@extends('landing_page_user')
@section('content')
<style>
    .feedback-card {
        max-width: 550px;
        margin: 60px auto;
        padding: 50px 80px;
        border-radius: 25px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        background: #fff;
        text-align: center;
    }

    .feedback-card h3 {
        font-weight: bold;
        margin-bottom: 30px;
        font-size: 28px;
    }

    .form-control,
    textarea {
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 16px;
        margin-bottom: 25px;
        border: 1px solid #ccc;
        width: 100%;
    }

    .form-label {
        display: block;
        margin-bottom: 15px;
        text-align: center;
        font-size: 16px;
    }

    .radio-group {
        display: flex;
        justify-content: center;
        gap: 60px;
        margin-bottom: 30px;
    }

    .form-check-input {
        transform: scale(1.4);
        margin-right: 10px;
    }

    .submit-btn {
        background-color: #3498db;
        border: none;
        padding: 12px 35px;
        border-radius: 12px;
        color: #fff;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #2980b9;
    }

    @media (max-width: 576px) {
        .radio-group {
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .feedback-card {
            padding: 30px 20px;
        }
    }
</style>

<div class="feedback-card">
    <h3>Feedback</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="text-align: left;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('feedback.store') }}">
        @csrf

        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Pasien" value="{{ old('name') }}">

        <label class="form-label">Bagaimana pendapat anda terhadap pelayanan kami?</label>
        <div class="radio-group">
            <label>
                <input class="form-check-input" type="radio" name="satisfaction" value="puas" {{ old('satisfaction') == 'puas' ? 'checked' : '' }}>
                Puas
            </label>
            <label>
                <input class="form-check-input" type="radio" name="satisfaction" value="kurang_puas" {{ old('satisfaction') == 'kurang_puas' ? 'checked' : '' }}>
                Tidak Puas
            </label>
        </div>

        <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" rows="4" placeholder="Komentar">{{ old('comment') }}</textarea>

        <button type="submit" class="submit-btn">Submit</button>
    </form>
</div>
@endsection
