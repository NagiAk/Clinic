@extends('layout')

@section('title', 'Demande de Rendez-vous')

@section('content')
<style>
    .fr{
        background: linear-gradient(110deg, #8ebbe286 50%, #e2f1e585 50%);
    }
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card fr">
                    <div class="card-header">Demande de Rendez-vous</div>

                    <div class="card-body">
                        <form action="{{ route('sendForm') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name">Votre Nom et Prénom</label>
                                <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cin">Votre CIN</label>
                                <input type="text" class="form-control" id="cin" name="cin" value="{{ old('cin') }}" required>
                                @error('cin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Votre Adresse E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">Votre Numéro de Téléphone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="specialite">Spécialité</label>
                                <select class="form-control" id="specialite" name="specialite" required>
                                    <option value="">Sélectionner une spécialité</option>
                                    @foreach($specialites as $sp)
                                        <option value="{{ $sp->id }}" {{ old('specialite') == $sp->id ? 'selected' : '' }}>{{ $sp->nom }}</option>
                                    @endforeach
                                </select>
                                @error('specialite')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="availability">Disponibilités préférées</label>
                                <input type="date" class="form-control" id="availability" name="availability" value="{{ old('availability') }}" required>
                                @error('availability')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Envoyer la demande</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
