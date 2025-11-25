@extends('admin.layout')
@section('title', 'User Details')
@section('content')

<div class="container py-4">

    <h3>User Details</h3>
    <hr>

    {{-- USER INFO --}}
    <div class="card mb-4">
        <div class="card-body">

            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset($user->avatar ?? 'images/default.png') }}" width="70" class="rounded-circle">

                <div>
                    <h5>{{ $user->name }}</h5>
                    <p class="m-0">
                        Email: {{ $user->email ?? 'N/A' }} <br>
                        Phone: {{ $user->phone ?? 'N/A' }} <br>
                        <!--Status: {{ $user->status ?? 'N/A' }}
                        <span class="badge bg-success">{{ $user->status }}</span>-->
                    </p>
                </div>
            </div>
			
			<div class="table-responsive mt-5">
				<table class="table table-bordered table-striped">
					<thead class="table-dark">
						<tr>
							<th>ID</th>
							<th>Subtotal</th>
							<th>Tax</th>
							<th>Total</th>
							<th>Status</th>
							<th>Date</th>
						</tr>
					</thead>

					<tbody>
						@foreach($orders as $order)
						<tr>
							<td>{{ $order->id }}</td>
							<td>{{ $order->subtotal }}৳</td>
							<td>{{ $order->tax }}৳</td>
							<td>{{ $order->total }}৳</td>
							<td><span class="badge bg-info">{{ $order->status }}</span></td>
							<td>{{ $order->created_at->format('Y-m-d') }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

        </div>
    </div>


   
 

</div>

@endsection
