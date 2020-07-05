<main class="content__main">
    <h2 class="content__main-heading">Вход на сайт</h2>

    <form class="form" action="index.html" method="post" autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input form__input--error" type="text" name="email" id="email" value="" placeholder="Введите e-mail">

            <p class="form__message">E-mail введён некорректно</p>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

            <input class="form__input" type="password" name="password" id="password" value="" placeholder="Введите пароль">
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Войти">
        </div>
    </form>

</main>