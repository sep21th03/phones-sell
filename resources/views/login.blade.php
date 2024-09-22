@extends('components.main')
@section('title', 'Đăng nhập')
@section('content')
<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
    <div class="card-header">Đăng nhập</div>
    <form>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Usename</label>
            <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="button" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>

<hr>
Banj chuwa cos taif khoaarn?
<a href="{{route('register')}}">Register</a>
<script>
    document.querySelector('button[name="submit"]').addEventListener('click', function() {
        let email = document.querySelector('input[name="email"]').value;
        let password = document.querySelector('input[name="password"]').value;
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (!email) {
            alert('Username is required');
            return;
        }
        if (!password) {
            alert('Password is required');
            return;
        }
        this.innerHTML = 'Vui lòng chờ...';
        this.disabled = true;
        fetch('/api/user/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    localStorage.setItem('token', data.access_token);
                    alert('Login success');
                    window.location.href = "{{ route('dashboard') }}";
                } else {
                    alert('Login failed');
                    this.innerHTML = 'Submit';
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Login failed');
                this.innerHTML = 'Submit';
                this.disabled = false;
            })
            .finally(() => {
                this.innerHTML = 'Submit';
                this.disabled = false;
            });
    });
</script>
@endsection