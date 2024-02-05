<x-jet-action-section>
  <x-slot name="title">
      {{ __('Sesiones Iniciadas') }}
  </x-slot>

  <x-slot name="description">
      {{ __('Administra y cierra la sesión de tus sesiones activas en otros navegadores y dispositivos.') }}
  </x-slot>

  <x-slot name="content">
      <x-jet-action-message on="loggedOut">
          {{ __('Sesiones cerradas correctamente.') }}
      </x-jet-action-message>

      <p class="card-text">
          {{ __('Puedes cerrar la sesión de todas tus otras sesiones del navegador en todos tus dispositivos. A continuación se muestra una lista de algunas de tus sesiones recientes; sin embargo, esta lista puede no ser exhaustiva. Si crees que tu cuenta ha sido comprometida, también debes actualizar tu contraseña.') }}
      </p>

     @if (count($this->sessions) > 0)
      <div class="mt-3">
        <!-- Other Browser Sessions -->
        @foreach ($this->sessions as $session)
          <div class="d-flex mb-50">
            <div>
              @if ($session->agent->isDesktop())
                <svg fill="none" width="32" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  viewBox="0 0 24 24" stroke="currentColor" class="text-muted">
                  <path
                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                  </path>
                </svg>
              @else
                <svg xmlns="http://www.w3.org/2000/svg" width="32" viewBox="0 0 24 24" stroke-width="2"
                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                  class="text-muted">
                  <path d="M0 0h24v24H0z" stroke="none"></path>
                  <rect x="7" y="4" width="10" height="16" rx="1"></rect>
                  <path d="M11 5h2M12 17v.01"></path>
                </svg>
              @endif
            </div>

            <div class="ms-2">
              <div>
                {{ $session->agent->platform() ? $session->agent->platform() : 'Unknown' }} -
                {{ $session->agent->browser() ? $session->agent->browser() : 'Unknown' }}
              </div>

              <div>
                <div class="small text-muted">
                  {{ $session->ip_address }},

                  @if ($session->is_current_device)
                    <span class="text-success fw-bolder">{{ __('Este dispositivo') }}</span>
                  @else
                    {{ __('Activo') }} {{ $session->last_active }}
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif

      <!-- Boton para cerrar sesion de otros navegadores -->
      <div class="d-flex mt-3">
          <x-jet-button wire:click="confirmLogout" wire:loading.attr="disabled">
              {{ __('Cerrar sesión en otros navegador') }}
          </x-jet-button>
      </div>

      {{-- CUADRO DE DIALOGO --}}
      <!-- Titulo de cuadro de dialogo -->
      <x-jet-dialog-modal wire:model="confirmingLogout">
          <x-slot name="title">
              {{ __('Cerrar sesiones activas') }}
          </x-slot>

          <x-slot name="content">
              {{ __('Por favor, ingresa tu contraseña para confirmar que deseas cerrar sesión en todas las demás sesiones del navegador en todos tus dispositivos.') }}

              <div class="mt-3" x-data="{}"
              x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
              <x-jet-input type="password" placeholder="{{ __('Contraseña') }}" x-ref="password"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}" wire:model.defer="password"
                wire:keydown.enter="logoutOtherBrowserSessions" />
              
                <div class="text-danger mt-2" id="PasswordError"></div> <!-- Contenedor para el mensaje de error personalizado -->
            
              <x-jet-input-error for="password" class="mt-2" />
            </div>
          </x-slot>

          <x-slot name="footer">
              <x-jet-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                  {{ __('Cancelar') }}
              </x-jet-secondary-button>

              <button class="btn btn-danger ms-1 text-uppercase" wire:click="logoutOtherBrowserSessions"
                  wire:loading.attr="disabled">
                  {{ __('Cerrar sesiones') }}
              </button>
          </x-slot>
      </x-jet-dialog-modal>
  </x-slot>
</x-jet-action-section>

<script>
  document.addEventListener('livewire:load', function () {
      $(document).on('click', '[wire\\:click^="logoutOtherBrowserSessions"]', function (e) {
          // Validar la contraseña con jQuery
          var password = $('#password').val().trim();
             if (!Hash::check($this->password, auth()->user()->password)) {
        $this->passwordError = 'Contraseña incorrecta.';
        return;
    }


          if (password === '') {
              $('#PasswordError').text('Por favor, ingresa tu contraseña.');
              e.preventDefault();
          } else {
              $('#PasswordError').text('');
          }
      });
  });
</script>
