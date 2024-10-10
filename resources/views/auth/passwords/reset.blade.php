<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <label for="password">Mật khẩu mới:</label>
    <input type="password" name="password" id="password" required>
    <label for="password_confirmation">Xác nhận mật khẩu:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>
    <button type="submit">Đặt lại mật khẩu</button>
</form>
