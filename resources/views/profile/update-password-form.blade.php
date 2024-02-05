<x-jet-form-section submit="updatePassword">
  <x-slot name="title">
    {{ __('Actualizar contraseña') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Asegúrate de que tu cuenta esté utilizando una contraseña larga y aleatoria para mantenerla segura.') }}
  </x-slot>

  <x-slot name="form">
    <div class="mb-3">
      <x-jet-label class="form-label" for="current_password" value="{{ __('Contraseña actual') }}" />
      <x-jet-input id="current_password" type="password"
        class="{{ $errors->has('current_password') ? 'is-invalid' : '' }}" wire:model.defer="state.current_password"
        autocomplete="current-password" />
      <x-jet-input-error for="current_password" />
      <div class="text-danger" id="current_passwordError"></div>
    </div>

    <div class="mb-3">
      <x-jet-label class="form-label" for="password" value="{{ __('Nueva contraseña') }}" />
      <x-jet-input id="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
        wire:model.defer="state.password" autocomplete="new-password" />
      <x-jet-input-error for="password" />
      <div class="text-danger" id="passwordError"></div>
    </div>

    <div class="mb-3">
      <x-jet-label class="form-label" for="password_confirmation" value="{{ __('Confirmar Nueva Contraseña') }}" />
      <x-jet-input id="password_confirmation" type="password"
        class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
        wire:model.defer="state.password_confirmation" autocomplete="new-password" />
      <x-jet-input-error for="password_confirmation" />
      <div class="text-danger" id="password_confirmationError"></div>
    </div>
  </x-slot>


  <!-- Boton Guardar -->
  <x-slot name="actions">
    <div class="d-flex align-items-baseline">
        <x-jet-button id="guardar-button">
            {{ __('Guardar') }}
        </x-jet-button>
    </div>
</x-slot>
</x-jet-form-section>

<script>
  document.addEventListener('livewire:load', function () {
      $(document).on('click', '#guardar-button', function (e) {

      // Validar los campos
      var currentPassword = $('#current_password').val().trim();
          var newPassword = $('#password').val().trim();
          var confirmPassword = $('#password_confirmation').val().trim();

          if (currentPassword === '') {
            $('#current_passwordError').text('Por favor, ingrese su contraseña actual.');
            e.preventDefault();
          } else {
            $('#current_passwordError').text('');
          }

          if (newPassword === '') {
            $('#passwordError').text('Por favor, ingrese su nueva contraseña.');
            e.preventDefault();
          } else {
            $('#passwordError').text('');
          }


          if (confirmPassword === '') {
            $('#password_confirmationError').text('Por favor, confirme su nueva contraseña.');
            e.preventDefault();
          } else {
            $('#password_confirmationError').text('');
          }

          // Verificar si las contraseñas nuevas coinciden
          if (newPassword !== confirmPassword) {
            $('#new-passwordError').text('Las contraseñas no coinciden.');
            e.preventDefault();
          } else {
            $('#new-passwordError').text('');
          }

          // Si pasa las validaciones, envía el formulario
          Livewire.emit('updatePassword');
      });
  });
</script>