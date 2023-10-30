@php
    /**
     * @var \App\Models\User $user
     * @var string $password
     */
@endphp
    <!DOCTYPE html>
<html>
<body>
<h1>Приветсвую, {{$user->name . ' ' . $user->surname}} </h1>
<p>Новый пароль: {{ $password }}</p>
</body>
</html>
