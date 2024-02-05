<table style="border-collapse: collapse; width: 100%;  text-align: center;">
    <!-- ENCABEZADOS DE TABLA -->
    <thead>
        <tr>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; width: 100%; text-align: center;">Id</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; width: 300%; text-align: center;">Nombre de empleado</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; width: 400%; text-align: center;">Correo</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; width: 300%; text-align: center;">Fecha de creación</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; width: 300%; text-align: center;">Fecha de actualización</th>
        </tr>
    </thead>
    <!-- INFORMACIÓN DE BASE DE DATOS EN TABLA -->
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $user->id }}</td>
            <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $user->name }}</td>
            <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $user->email }}</td>
            <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $user->created_at }}</td>
            <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $user->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>