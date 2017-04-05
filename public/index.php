<?
use Core\View as v;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
// TODO title
$APPLICATION->SetTitle("Грумелье");
?>

<section class="banner">
    <div class="wrap">
        <h1>Груминг. Гостиница. Зоомагазин</h1>
        <div class="dog_line"></div>
        <h2>Самый большой и современный сервис для Ваших любимых питомцев</h2>
        <span class="next" data-href="next"></span>
    </div>
</section>
<section class="service" data-anchor="next">
    <div class="left wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0s"></div>
    <div class="right wow fadeInRight" data-wow-duration="1s" data-wow-delay="0s"></div>
    <div class="wrap">
        <strong class="heading"><h2>Сервис</h2></strong>
        <div class="grid">
            <a href="#" class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay="1.2s">
        <span class="img">
          <img src="<?= v::asset('images/1-1.png') ?>" alt="">
          <span class="shape">
            <span>Груминг Cалон</span>
        </span>
        </span>
                <span class="info">
          <span class="ico">
            <img src="<?= v::asset('images/icon-grouming.png') ?>" alt="">
          </span>
        <span class="text">Наши профессиональные и квалифицированные грумеры-стилисты, владеющие техникой
безопасности при работе с кошками и собаками, всегда помогут Вашему питомцу
выглядеть великолепно.</span>
        </span>
            </a>
            <a href="#" class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay="1.6s">
        <span class="img">
          <img src="<?= v::asset('images/2-2.png') ?>" alt="">
          <span class="shape">
            <span>Гостиница</span>
        </span>
        </span>
                <span class="info">
          <span class="ico">
            <img src="<?= v::asset('images/icon-hotel.png') ?>" alt="">
          </span>
        <span class="text">В нашем зоомагазине вы найдете широкий ассортимент качественной продукции для Вашего питомца. Вы всегда сможете порадовать Вашего любимца кормами, аксессуарами, лакомствами, игрушками и одеждой.</span>
        </span>
            </a>
            <a href="#" class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay="2s">
        <span class="img">
          <img src="<?= v::asset('images/3-2.png') ?>" alt="">
          <span class="shape">
            <span>Зоомагазин</span>
        </span>
        </span>
                <span class="info">
          <span class="ico">
            <img src="<?= v::asset('images/icon-market.png') ?>" alt="">
          </span>
        <span class="text">Наша гостиница предоставляет Вашему питомцу комфортабельное размещение и обеспечивает доброжелательную атмосферу в специально оборудованных номерах с комплексной системой безопасности.</span>
        </span>
            </a>
            <a href="#" class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay="2.4s">
        <span class="img">
          <img src="<?= v::asset('images/4-1.png') ?>" alt="">
          <span class="shape">
            <span>Зоотакси</span>
        </span>
        </span>
                <span class="info">
          <span class="ico">
            <img src="<?= v::asset('images/icon-taxi.png') ?>" alt="">
          </span>
        <span class="text">Наше специализированное зоотакси обеспечит комфортабельное и безопасное путешествие для Вас и Вашего питомца. Мы заботимся о комфорте и безопасности Вас и Ваших любимцев!</span>
        </span>
            </a>
        </div>
    </div>
</section>
<section class="why_us">
    <div class="wrap wrap_why_us">
        <strong class="heading"><h2>Почему мы?</h2></strong>
        <div class="grid slider_why_us">
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".2s">
                <div class="ico">
                    <img src="<?= v::asset('images/personal.png') ?>" alt="">
                </div>
                <strong>Квалифицированный персонал</strong>
                <p>Все наши сотрудники имеют сертификаты и дипломы, подтверждающие их высокий уровень квалификации и навыков работы с животными.</p>
            </div>
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".5s">
                <div class="ico">
                    <img src="<?= v::asset('images/cosmetics.png') ?>" alt="">
                </div>
                <strong>Профессиональная косметика</strong>
                <p>Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику.</p>
            </div>
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".8s">
                <div class="ico">
                    <img src="<?= v::asset('images/facility.png') ?>" alt="">
                </div>
                <strong>Современное оборудование</strong>
                <p>Наличие лучшего оборудования позволяет нам ухаживать за Вашими питомцами на самом высоком уровне.</p>
            </div>
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay="1.1s">
                <div class="ico">
                    <img src="<?= v::asset('images/flexibility.png') ?>" alt="">
                </div>
                <strong>Индивидуальный подход</strong>
                <p>Каждый домашний питомец индивидуален. Наши сотрудники, имея большой опыт работы с четвероногими любимцами, умеют найти общий язык с каждым из них.</p>
            </div>
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay="1.4s">
                <div class="ico">
                    <img src="<?= v::asset('images/price.png') ?>" alt="">
                </div>
                <strong>Привлекательные цены</strong>
                <p>Наша компания предлагает широкий выбор пакетов услуг по уходу за Вашим питомцем. Высокое качество по доступным ценам – кредо нашей компании.</p>
            </div>
        </div>
    </div>
</section>
<div class="dots dots_why_us"></div>
<section class="shares">
    <div class="wrap">
        <strong class="heading"><h2>Акции</h2></strong>
        <div class="grid slider_shares">
            <a href="#" class="item">
                <img src="<?= v::asset('images/special-1.png') ?>" alt="">
                <div class="discount right bottom" style="background: rgba(153, 153, 153, 0.6)">Скидка на гостиницу - 50%!</div>
                <div class="info">
                    <p>Только с 01.10 по 30.11! Груминг для самых пушистых - 999 рублей!</p>
                </div>
            </a>
            <a href="#" class="item">
                <img src="<?= v::asset('images/special-2.png') ?>" alt="">
                <div class="discount left top" style="background: rgba(204, 106, 0, 0.6);">Зоотакси в подарок!</div>
                <div class="info">
                    <p>Только с 01.10 по 30.11! Груминг для самых пушистых - 999 рублей!</p>
                </div>
            </a>
            <a href="#" class="item">
                <img src="<?= v::asset('images/special-3.png') ?>" alt="">
                <div class="discount right bottom" style="background: rgba(153, 153, 153, 0.6)">Скидка на гостиницу - 50%!</div>
                <div class="info">
                    <p>Только с 01.10 по 30.11! Груминг для самых пушистых - 999 рублей!</p>
                </div>
            </a>
            <a href="#" class="item">
                <img src="<?= v::asset('images/special-4.png') ?>" alt="">
                <div class="discount left top" style="background: rgba(204, 106, 0, 0.6);">Зоотакси в подарок!</div>
                <div class="info">
                    <p>Только с 01.10 по 30.11! Груминг для самых пушистых - 999 рублей!</p>
                </div>
            </a>
            <a href="#" class="item">
                <img src="<?= v::asset('images/special-5.png') ?>" alt="">
                <div class="discount right top" style="background: rgba(153, 153, 153, 0.6)">Скидка на гостиницу - 50%!</div>
                <div class="info">
                    <p>Только с 01.10 по 30.11! Груминг для самых пушистых - 999 рублей!</p>
                </div>
            </a>
            <a href="#" class="item">
                <img src="<?= v::asset('images/special-6.png') ?>" alt="">
                <div class="discount right top" style="background: rgba(204, 106, 0, 0.6);">Зоотакси в подарок!</div>
                <div class="info">
                    <p>Только с 01.10 по 30.11! Груминг для самых пушистых - 999 рублей!</p>
                </div>
            </a>
        </div>
    </div>
</section>
<div class="dots dots_shares"></div>
<section class="gallery">
    <strong class="heading"><h2>Галерея</h2></strong>
    <div class="grid slider_gallery">
        <div class="item">
            <a class="gellery_item" rel="gallery" href="<?= v::asset('images/gal_1.jpg') ?>">
                <img src="<?= v::asset('images/gal_1.jpg') ?>" alt="" />
            </a>
        </div>
        <div class="item">
            <a class="gellery_item" rel="gallery" href="<?= v::asset('images/gal_2.jpg') ?>">
                <img src="<?= v::asset('images/gal_2.jpg') ?>" alt="" />
            </a>
        </div>
        <div class="item">
            <a class="gellery_item" rel="gallery" href="<?= v::asset('images/gal_3.jpg') ?>">
                <img src="<?= v::asset('images/gal_3.jpg') ?>" alt="" />
            </a>
        </div>
        <div class="item">
            <a class="gellery_item" rel="gallery" href="<?= v::asset('images/gal_4.jpg') ?>">
                <img src="<?= v::asset('images/gal_4.jpg') ?>" alt="" />
            </a>
        </div>
        <div class="item">
            <a class="gellery_item" rel="gallery" href="<?= v::asset('images/gal_5.jpg') ?>">
                <img src="<?= v::asset('images/gal_5.jpg') ?>" alt="" />
            </a>
        </div>
        <div class="item">
            <a class="gellery_item" rel="gallery" href="<?= v::asset('images/gal_6.jpg') ?>">
                <img src="<?= v::asset('images/gal_6.jpg') ?>" alt="" />
            </a>
        </div>
        <div class="item">
            <a class="gellery_item" rel="gallery" href="<?= v::asset('images/gal_7.jpg') ?>">
                <img src="<?= v::asset('images/gal_7.jpg') ?>" alt="" />
            </a>
        </div>
        <div class="item">
            <a class="gellery_item" rel="gallery" href="<?= v::asset('images/gal_8.jpg') ?>">
                <img src="<?= v::asset('images/gal_8.jpg') ?>" alt="" />
            </a>
        </div>
    </div>
</section>
<div class="dots dots_gallery"></div>
<section class="banners">
    <div class="wrap">
        <div class="grid">
            <a class="item" href="#">
                <img src="<?= v::asset('images/banner_2.jpg') ?>" alt="">
            </a>
            <a class="item" href="#">
                <img src="<?= v::asset('images/banner.jpg') ?>" alt="">
            </a>
        </div>
    </div>
</section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>