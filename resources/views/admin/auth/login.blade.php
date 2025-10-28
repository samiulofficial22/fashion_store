<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    Admin Login
                </div>
                <div class="card-body">
					{{-- Display validation errors --}}
					@if($errors->any())
						<div class="alert alert-danger">
							<ul class="mb-0">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form method="POST" action="{{ route('admin.login.submit') }}">
						@csrf
						<div class="mb-3">
							<label>Email</label>
							<input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
						</div>
						<div class="mb-3">
							<label>Password</label>
							<input type="password" name="password" class="form-control" required>
						</div>
						<button class="btn btn-primary w-100">Login</button>
					</form>
				</div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
