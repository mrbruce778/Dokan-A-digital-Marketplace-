@extends('dashboard')

@section('content')
<div class="support-ticket-container">
    <h2 class="support-ticket-title">Submit a Support Ticket</h2>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error message -->
    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('customer.service.submit') }}" class="support-ticket-form">
        @csrf

        <!-- Issue Subject -->
        <div class="form-group">
            <label for="issue_subject">Subject</label>
            <input type="text" name="issue_subject" id="issue_subject" class="form-control" required>
            @error('issue_subject')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- Issue Description -->
        <div class="form-group">
            <label for="issue_description">Description</label>
            <textarea name="issue_description" id="issue_description" rows="5" class="form-control" required></textarea>
            @error('issue_description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary submit-btn">Submit Ticket</button>
    </form>

    <div class="back-link">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>
@endsection
