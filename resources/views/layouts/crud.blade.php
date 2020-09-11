@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Empleados</title>
    <link rel="stylesheet" href="{% static 'css/bootstrap.css' %}">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center alert alert-danger">Gestión Empleados</h2>
    {% block content %}
    {% endblock content %}
</div>
<script src="{% static 'js/bootstrap.js' %}"></script>
<script src="{% static 'js/popper.js' %}"></script>
<script src="{% static 'js/jquery.js' %}"></script>
</body>
</html>
