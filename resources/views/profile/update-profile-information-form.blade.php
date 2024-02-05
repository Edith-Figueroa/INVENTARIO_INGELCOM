<x-jet-form-section submit="updateProfileInformation">
  <x-slot name="title">
    {{ __('Información de Empleado') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Actualiza la información de perfil y la dirección de correo electrónico de tu cuenta.') }}
  </x-slot>

  <x-slot name="form">

    <x-jet-action-message on="saved">
      {{ __('Cambios actualizados.') }}
    </x-jet-action-message>
 
    <!-- Nombre del empleado -->
    <div class="mb-3">
      <x-jet-label class="form-label" for="name" value="{{ __('Nombre') }}" />
      <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
        wire:model.defer="state.name" autocomplete="name" />
      <x-jet-input-error for="name" />
      <div class="text-danger" id="NameError"></div>
    </div>

    <!-- Correo -->
    <div class="mb-3">
      <x-jet-label class="form-label" for="email" value="{{ __('Correo') }}" />
      <x-jet-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
        wire:model.defer="state.email" />
      <x-jet-input-error for="email" />
      <div class="text-danger" id="emailError"></div>
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
          var name = $('#name').val().trim();
          var email = $('#email').val().trim();

          if (name === '') {
            $('#NameError').text('Por favor, ingrese un nombre.');
            e.preventDefault();
          }

          if (email === '') {
              $('#emailError').text('Por favor, ingrese un correo.');
              e.preventDefault();
          }

          // Si pasa las validaciones, envía el formulario
          Livewire.emit('updateProfileInformation');
      });
  });
</script>
