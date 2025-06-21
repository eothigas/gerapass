<div class="container" id="widget">
    <div class="row flex align-items-start">
        <div class="col-10 col-md-9 col-lg-9">
            <div class="welcome">
                <h4>Bem vindo</h4>
                <h2 style="color: var(--secondary);"><?php echo $_SESSION['nome'] ?? 'Usuário' ?>!</h2>
            </div>
        </div>
        <div class="col-10 col-md-3 col-lg-3">
            <div class="card <?php echo $classes['card_class']; ?>">
                <p class="time-text"><span><?php echo horaAtualComFuso($fuso); ?></span></p>
                <p class="day-text"><?php echo diaFormatadoComFuso($fuso); ?></p>
                <i class="bi bi-moon moon <?php echo $classes['moon_class']; ?>"></i>
                <i class="bi bi-sun sun <?php echo $classes['sun_class']; ?>"></i>
            </div>
        </div>
    </div>
</div>