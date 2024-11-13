@extends('layouts.app')

@section('title', 'Main Menu')

@section('content')
    <div class="main-menu-container">
        <div class="overlay">

            <!-- Text Box with Semi-Transparent Background -->
            <div class="col-md-8 col-lg-4 text-box text-center">
                <h1>Main Menu</h1>
                <p>Select a session or category to start the quiz:</p>

                <!-- Form to submit session selection -->
                <form id="sessionForm" class="row justify-content-center" method="GET">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label for="session" class="form-label">Select Category</label>
                        <select name="session" id="session" class="form-select" required>
                            <option value="" disabled selected>Select a session</option>
                            <option value="1">Session 1</option>
                            <option value="2">Session 2</option>
                            <option value="3">Session 3</option>
                            <option value="4">Session 4</option>
                            <option value="5">Session 5</option>
                            <option value="6">Session 6</option>
                            <option value="7">Session Training</option>
                        </select>
                    </div>

                    <!-- Submit button -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Start Quiz</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

    <script>
        document.getElementById('sessionForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting right away

            // Get the selected session value
            var sessionId = document.getElementById('session').value;

            // Redirect to the selected session and start from question 0
            var actionUrl = "{{ url('/quiz/session') }}/" + sessionId + "/0"; // Starting at questionIndex = 0
            window.location.href = actionUrl;
        });
    </script>
@endsection

<!-- Custom CSS -->
<style>
    .main-menu-container {
        background-color: #5b4c23;
        background-image: url('{{ asset('images/background.png') }}');
        background-size: 90%;
        background-repeat: no-repeat;
        /* Prevent the background image from repeating */
        background-position: center;
        /* Center the background image */
        height: 100vh;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }


    /* Adding a translucent overlay for better readability */
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent black */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Style for the text box */
    .text-box {
        background-color: rgba(255, 255, 255, 0.8);
        /* Semi-transparent white background */
        padding: 20px;
        margin-top: 10em;
        border-radius: 10px;
        z-index: 2;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Optional: Add shadow for better visual effect */
        width: 100%;
    }

    /* Styling for the text inside the box */
    h1,
    p {
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        /* Add shadow for better visibility */
        color: black;
    }

    .btn-primary {
        background-color: #f7b500;
        border-color: #f7b500;
        font-weight: bold;
    }
</style>
