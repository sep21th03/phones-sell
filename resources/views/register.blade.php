@extends('components.main')
@section('title', 'Đăng ký')
@section('content')
<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
    <div class="card-header">Đăng ký</div>
    <form>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Usename</label>
            <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Repassword</label>
            <input type="password" name="repassword" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="button" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>

<hr>
Ban chua co tai khoan?
<a href="{{route('login_page')}}">Register</a>
<script>
    document.querySelector('button[name="submit"]').addEventListener('click', function() {
        let name = document.querySelector('input[name="name"]').value;
        let email = document.querySelector('input[name="email"]').value;
        let password = document.querySelector('input[name="password"]').value;
        let repassword = document.querySelector('input[name="repassword"]').value;
        let address = document.querySelector('input[name="address"]').value
        let phone = document.querySelector('input[name="phone"]').value;
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        this.innerHTML = 'Vui lòng chờ...';
        this.disabled = true;
        fetch('/api/user/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                    repassword: repassword,
                    address: address,
                    phone: phone
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Register success');
                    window.location.href = '/user/login';
                } else {
                    alert('Register failed');
                    this.innerHTML = 'Submit';
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Register failed 2');
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