<div class="create-replay">
    <div class="create-replay__title">

        <svg class="title__icon"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
        	<path d="M497,37h-65.7c0.2-7.3,0.4-14.6,0.4-22c0-8.3-6.7-15-15-15H95.3c-8.3,0-15,6.7-15,15c0,7.4,0.1,14.7,0.4,22H15
                C6.7,37,0,43.7,0,52c0,67.2,17.6,130.6,49.5,178.6c31.5,47.4,73.5,74.6,118.9,77.2c10.3,11.2,21.2,20.3,32.5,27.3v66.7h-25.2
                c-30.4,0-55.2,24.8-55.2,55.2V482h-1.1c-8.3,0-15,6.7-15,15c0,8.3,6.7,15,15,15h273.1c8.3,0,15-6.7,15-15c0-8.3-6.7-15-15-15h-1.1
                v-25.2c0-30.4-24.8-55.2-55.2-55.2h-25.2V335c11.3-7,22.2-16.1,32.5-27.3c45.4-2.6,87.4-29.8,118.9-77.2
                C494.4,182.6,512,119.2,512,52C512,43.7,505.3,37,497,37z M74.4,213.9C48.1,174.4,32.7,122.6,30.3,67h52.1
                c5.4,68.5,21.5,131.7,46.6,182c4,8,8.2,15.6,12.5,22.7C116.6,262.2,93.5,242.5,74.4,213.9z M437.6,213.9
                c-19,28.6-42.1,48.3-67.1,57.7c4.3-7.1,8.5-14.7,12.5-22.7c25.1-50.2,41.2-113.5,46.6-182h52.1
                C479.3,122.6,463.9,174.4,437.6,213.9z"/>
        </svg>

        <p class="title__text">Создать новый Replay</p>
    </div>
    <div class="create-replay__body">
        <form class="create-replay__form" action="GET">

            <div class="form-group">
                <label for="create-replay-name">* Название:</label>
                <input type="text" class="form-control" id="create-replay-name">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__user-replay">* Пользовательский/Gosu:
                            <select id="create-replay__user-replay" class="create-replay__user-replay">
                                <option>Пользовательский</option>
                                <option>Gosu</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__type">* Тип:
                            <select id="create-replay__type" class="create-replay__type">
                                <option>duel</option>
                                <option>pack</option>
                                <option>gotw</option>
                                <option>team</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="create-replay__map">* Карта:
                    <select class="js-example-basic-single" name="map" id="create-replay__map">
                        <option>Andromeda</option>
                        <option>Arcadia II</option>
                        <option>Azalea</option>
                        <option>Bifrost</option>
                        <option>Dire Straits</option>
                    </select>
                </label>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__first-race">* Первая раса:
                            <select id="create-replay__first-race" class="create-replay__first-race">
                                <option>All</option>
                                <option>Z</option>
                                <option>T</option>
                                <option>P</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__first-country">* Первая страна:
                            <select class="js-example-basic-single" name="country" id="create-replay__first-country">
                                <option>Ukraine</option>
                                <option>Italy</option>
                                <option>France</option>
                                <option>Poland</option>
                                <option>USA</option>
                            </select>
                        </label>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <label for="create-replay__second-location">* Вторая локация:</label>
                <input type="text" class="form-control" id="create-replay__second-location">
            </div>

            <hr>

            <div class="form-group">
                <label for="video_iframe">Вставить HTML код с Youtube с видео реплеем</label>
                <textarea name="video_iframe" class="form-control " id="video_iframe" rows="16" style="display: none;"></textarea>
            </div>

            <div class="create-replay__button">
                <button class="button button__download-more">
                    Создать
                </button>
            </div>


        </form>
    </div>
</div>
