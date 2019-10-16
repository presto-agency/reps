<div class="gallery-detail">
    <div class="gallery-detail__title">

        <svg class="title__icon"  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 512 512" xml:space="preserve">

            <path d="M437.019,74.98C388.667,26.629,324.38,0,256,0C187.619,0,123.331,26.629,74.98,74.98C26.628,123.332,0,187.62,0,256
                s26.628,132.667,74.98,181.019C123.332,485.371,187.619,512,256,512c68.38,0,132.667-26.629,181.019-74.981
                C485.371,388.667,512,324.38,512,256S485.371,123.333,437.019,74.98z M256,482C131.383,482,30,380.617,30,256S131.383,30,256,30
                s226,101.383,226,226S380.617,482,256,482z"/>

            <path d="M378.305,173.859c-5.857-5.856-15.355-5.856-21.212,0.001L224.634,306.319l-69.727-69.727
                c-5.857-5.857-15.355-5.857-21.213,0c-5.858,5.857-5.858,15.355,0,21.213l80.333,80.333c2.929,2.929,6.768,4.393,10.606,4.393
                c3.838,0,7.678-1.465,10.606-4.393l143.066-143.066C384.163,189.215,384.163,179.717,378.305,173.859z"/>
        </svg>

        <p class="title__text">Галерея</p>
    </div>
    <div class="gallery-detail__body">
        <div class="body__items">
            <div class="items__title">
                <p>Image name</p>
            </div>
            <div class="items__rating">
                <a class="rating__like" href="#">
                    <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve">
		                    <path d="M83.6,167.3H16.7C7.5,167.3,0,174.7,0,184v300.9c0,9.2,7.5,16.7,16.7,16.7h66.9c9.2,0,16.7-7.5,16.7-16.7V184
			                    C100.3,174.7,92.8,167.3,83.6,167.3z"></path>
                        <path d="M470.3,167.3c-2.7-0.5-128.7,0-128.7,0l17.6-48c12.1-33.2,4.3-83.8-29.4-101.8c-11-5.9-26.3-8.8-38.7-5.7
                            c-7.1,1.8-13.3,6.5-17,12.8c-4.3,7.2-3.8,15.7-5.4,23.7c-3.9,20.3-13.5,39.7-28.4,54.2c-26,25.3-106.6,98.3-106.6,98.3v267.5
                            h278.6c37.6,0,62.2-42,43.7-74.7c22.1-14.2,29.7-44,16.7-66.9c22.1-14.2,29.7-44,16.7-66.9C527.6,235.2,514.8,174.8,470.3,167.3z"></path>
                    </svg>
                    <span>3</span>
                </a>
                <a class="rating__dislike" href="#">
                    <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve">
		                    <path d="M83.6,167.3H16.7C7.5,167.3,0,174.7,0,184v300.9c0,9.2,7.5,16.7,16.7,16.7h66.9c9.2,0,16.7-7.5,16.7-16.7V184
			                    C100.3,174.7,92.8,167.3,83.6,167.3z"></path>
                        <path d="M470.3,167.3c-2.7-0.5-128.7,0-128.7,0l17.6-48c12.1-33.2,4.3-83.8-29.4-101.8c-11-5.9-26.3-8.8-38.7-5.7
                            c-7.1,1.8-13.3,6.5-17,12.8c-4.3,7.2-3.8,15.7-5.4,23.7c-3.9,20.3-13.5,39.7-28.4,54.2c-26,25.3-106.6,98.3-106.6,98.3v267.5
                            h278.6c37.6,0,62.2-42,43.7-74.7c22.1-14.2,29.7-44,16.7-66.9c22.1-14.2,29.7-44,16.7-66.9C527.6,235.2,514.8,174.8,470.3,167.3z"></path>
                    </svg>
                    <span>3</span>
                </a>
            </div>
            <div class="items__reputation-button">
                <a href="#">рейтинг лист</a>
            </div>
            <div class="items__slide-button">
                <a href="#">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </div>
        </div>
        <div class="body__img">
            <img src="{{ url('/images/starcraft-1.jpg') }}" alt="image">
        </div>
        <form action="" class="body__edit-image-form">
            <div class="form-group">
                <label for="gallery-name">Подпись:</label>
                <input type="text" class="form-control" id="gallery-name">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="gallery__for-adults" checked="">
                <label class="form-check-label" for="gallery__for-adults">
                    18+
                </label>
            </div>
            <div class="modal-body__add-btn">
                <button class="button button__download-more">
                    Обновить
                </button>
            </div>
        </form>
    </div>
</div>
