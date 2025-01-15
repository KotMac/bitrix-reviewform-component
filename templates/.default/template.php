<div class="review-form">
    <?php if (!empty($arResult["SUCCESS"])): ?>
        <div class="success-message"><?= htmlspecialchars($arResult["SUCCESS"]); ?></div>
    <?php endif; ?>

    <?php if (!empty($arResult["ERROR"])): ?>
        <div class="error-message"><?= htmlspecialchars($arResult["ERROR"]); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Имя клиента</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="review">Отзыв</label>
            <textarea id="review" name="review" required></textarea>
        </div>
        <div class="form-group">
            <label for="rating">Рейтинг (от 1 до 5)</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>
        </div>
        <button class="btn-primary" type="submit">Добавить отзыв</button>
    </form>
</div>


