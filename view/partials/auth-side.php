<?php /** @var string $authQuoteA */ /** @var string $authQuoteB */ ?>
<aside class="auth-side">
    <a href="index.php?p=landing" class="wordmark"><?php require __DIR__ . '/logo.php'; ?>Budget</a>
    <p class="auth-quote"><?= $authQuoteA ?><br><?= $authQuoteB ?></p>
    <div class="auth-figure" data-ui aria-hidden="true">
        <div class="answer-row">
            <span class="tile tint-3">C</span>
            <span class="answer-main"><span class="answer-title">Marché d'Aligre</span><span class="answer-sub">Courses · aujourd'hui</span></span>
            <span class="answer-amount num">52,17&nbsp;€</span>
        </div>
        <div class="answer-row">
            <span class="tile tint-0">S</span>
            <span class="answer-main"><span class="answer-title">Salaire novembre</span><span class="answer-sub">Salaire · 1<sup>er</sup> nov.</span></span>
            <span class="answer-amount num auth-in">+2&#8239;350,00&nbsp;€</span>
        </div>
    </div>
</aside>
