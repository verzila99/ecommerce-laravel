@guest
  <nav class="modal" >
    <div class="modal-background" ></div >
    <div class="modal-card" >

      <section class="modal-card-body login-form" >
        <button class="delete is-large" aria-label="close" ></button >
        <div class="tabs is-centered i is-medium" >
          <ul >
            <li class="is-active login-tab" >
              <a >
                <span >Войти</span >
              </a >
            </li >
            <li class="register-tab" >
              <a >
                <span >Регистрация</span >
              </a >
            </li >
          </ul >
        </div >
        <div

          class="login-modal is-flex-direction-column is-justify-content-space-around is-align-items-center"
        >

          <div class="field" >
            <label for="login-email" class="label" >Email</label >
            <p class="control has-icons-left has-icons-right" >
              <input id="login-email" name="email" class="input"
                     type="email"
                     placeholder="Email" />
              <span class="icon is-small is-left" >
                                <i class="fas fa-envelope" ></i >
                            </span >
              <span class="icon is-small is-right" >
                                <i class="fas fa-check" ></i >
                            </span >
            </p >
          </div >
          <div class="field" >
            <label for="login-password" class="label" >Пароль</label >
            <p class="control has-icons-left" >
              <input
                id="login-password"
                name="password"
                class="input"
                type="password"
                placeholder="Пароль"
              />
              <span class="icon is-small is-left" >
                                <i class="fas fa-lock" ></i >
                            </span >
            </p >
          </div >
          <div class="field is-flex is-align-items-center " >
            <label class="checkbox label" >
              <input type="checkbox" id="login-remember" name="remember_token" value="true" >
              Remember me
            </label >
            <a href="{{route('password.request')}}" class="ml-6">Забыли пароль?</a >
          </div >

          <div class="field" >
            <div id
                 ="login-error" class=" has-text-danger mb-3" ></div >
            <p class="control" >
              <a id="login-button" class="button is-success send-form" >Войти</a >
            </p >
          </div >
        </div >
        <div

          class="register-modal is-flex-direction-column is-justify-content-space-around is-align-items-center"
        >

          <div class="field" >
            <label for="register-name" class="label" >Имя</label >
            <p class="control has-icons-left" >
              <input id="register-name" class="input" name="name"
                     type="text"
                     placeholder="Имя" />
              <span class="icon is-small is-left" >
                                <i class="fas fa-user" ></i >
                            </span >
            </p >
          </div >

          <div class="field" >
            <label for="register-email" class="label" >Email</label >
            <p class="control has-icons-left " >
              <input id="register-email" class="input"
                     name="email" type="email"
                     placeholder="Email" />
              <span class="icon is-small is-left" >
                                <i class="fas fa-envelope" ></i >
                            </span >
            </p >
          </div >
          <div class="field" >
            <label for="register-password" class="label" >Пароль</label >
            <p class="control has-icons-left" >
              <input
                id="register-password"
                name="password"
                class="input"
                type="password"
                placeholder="Пароль"
              />
              <span class="icon is-small is-left" >
                                <i class="fas fa-lock" ></i >
                            </span >
            </p >
          </div >
          <div class="field" >
            <label for="register-confirmation" class="label" >
              Подтвердите пароль</label >
            <p class="control has-icons-left" >
              <input
                id="register-confirmation"
                name="password_confirmation"
                class="input"
                type="password"
                placeholder="Подтвердите пароль"
              />
              <span class="icon is-small is-left" >
                                <i class="fas fa-lock" ></i >
                            </span >
            </p >
          </div >
          <div class="field" >
            <div id
                 ="register-error" class="mb-3" ></div >
            <p class="control" >

              <a id="register" class="button is-success send-form" >Регистрация</a >
            </p >
          </div >
        </div >
      </section >
    </div >
  </nav >
@endguest
