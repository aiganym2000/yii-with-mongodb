//Функция скролла наверх
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#scrollToTop').fadeIn();
        } else {
            $('#scrollToTop').fadeOut();
        }
    });
    $('#scrollToTop').click(function () {
        $('body,html').animate({scrollTop: 0}, 700);
    });
});

function dropdown() {
    document.getElementById("dropdown").classList.toggle("show");
}

//Слайдер для сайта
function Sim(sldrId, loop, auto, interval, arrows, dots) {

    autos = auto;

    let id = document.getElementById(sldrId);
    if (id) {
        this.sldrRoot = id
    }
    else {
        this.sldrRoot = document.querySelector('.sim-slider')
    }

    this.sldrList = this.sldrRoot.querySelector('.sim-slider-list');
    this.sldrElements = this.sldrList.querySelectorAll('.sim-slider-element');
    this.sldrElemFirst = this.sldrList.querySelector('.sim-slider-element');
    this.leftArrow = this.sldrRoot.querySelector('div.sim-slider-arrow-left');
    this.rightArrow = this.sldrRoot.querySelector('div.sim-slider-arrow-right');
    this.indicatorDots = this.sldrRoot.querySelector('div.sim-slider-dots');

    this.options = {
        loop: loop,
        auto: auto,
        interval: interval,
        arrows: arrows,
        dots: dots
    };
    Sim.initialize(this)
}

Sim.prototype.elemPrev = function (num) {
    num = num || 1;

    let prevElement = this.currentElement;
    this.currentElement -= num;
    if (this.currentElement < 0) this.currentElement = this.elemCount - 1;

    if (!this.options.loop) {
        if (this.currentElement == 0) {
            this.leftArrow.style.display = 'none'
        }
        this.rightArrow.style.display = 'block'
    }

    this.sldrElements[prevElement].style.opacity = '0';
    var that = this;
    setTimeout(function () {
        that.sldrElements[prevElement].style.display = 'none';
        that.sldrElements[that.currentElement].style.display = 'block';
    }, 400);
    setTimeout(function () {
        that.sldrElements[that.currentElement].style.opacity = '1';
    }, 800);

    if (this.options.dots) {
        this.dotOn(prevElement);
        this.dotOff(this.currentElement)
    }
};

Sim.prototype.elemNext = function (num) {
    num = num || 1;

    let prevElement = this.currentElement;
    this.currentElement += num;
    if (this.currentElement >= this.elemCount) this.currentElement = 0;

    if (!this.options.loop) {
        if (this.currentElement == this.elemCount - 1) {
            this.rightArrow.style.display = 'none'
        }
        this.leftArrow.style.display = 'block'
    }

    this.sldrElements[prevElement].style.opacity = '0';
    var that = this;
    setTimeout(function () {
        that.sldrElements[prevElement].style.display = 'none';
        that.sldrElements[that.currentElement].style.display = 'block';
    }, 400);
    setTimeout(function () {
        that.sldrElements[that.currentElement].style.opacity = '1';
    }, 800);

    if (this.options.dots) {
        this.dotOn(prevElement);
        this.dotOff(this.currentElement)
    }
};

Sim.prototype.dotOn = function (num) {
    this.indicatorDotsAll[num].classList.remove("active");
    this.indicatorDotsAll[num].classList.add("inactive");
};

Sim.prototype.dotOff = function (num) {
    this.indicatorDotsAll[num].classList.add("active");
    this.indicatorDotsAll[num].classList.remove("inactive");
};

Sim.initialize = function (that) {

    that.elemCount = that.sldrElements.length;

    that.currentElement = 0;
    let bgTime = getTime();

    function getTime() {
        return new Date().getTime();
    }

    function setAutoScroll() {
        that.autoScroll = setInterval(function () {
            let fnTime = getTime();
            if (fnTime - bgTime + 10 > that.options.interval) {
                bgTime = fnTime;
                that.elemNext()
            }
        }, that.options.interval)
    }

    if (that.elemCount <= 1) {
        that.options.auto = false;
        that.options.arrows = false;
        that.options.dots = false;
        that.leftArrow.style.display = 'none';
        that.rightArrow.style.display = 'none'
    }
    if (that.elemCount >= 1) {
        that.sldrElemFirst.style.opacity = '1';
        that.sldrElemFirst.style.display = 'block';
    }

    if (!that.options.loop) {
        that.leftArrow.style.display = 'none';
        that.options.auto = false;
    }
    else if (that.options.auto) {
        setAutoScroll();
        that.sldrList.addEventListener('mouseenter', function () {
            clearInterval(that.autoScroll)
        }, false);
        that.sldrList.addEventListener('mouseleave', setAutoScroll, false)
    }

    if (that.options.arrows) {
        that.leftArrow.addEventListener('click', function () {
            let fnTime = getTime();
            if (fnTime - bgTime > 1000) {
                bgTime = fnTime;
                that.elemPrev()
            }
        }, false);
        that.rightArrow.addEventListener('click', function () {
            let fnTime = getTime();
            if (fnTime - bgTime > 1000) {
                bgTime = fnTime;
                that.elemNext()
            }
        }, false)
    }
    else {
        that.leftArrow.style.display = 'none';
        that.rightArrow.style.display = 'none'
    }
    ;

    if (that.options.dots) {
        let sum = '', diffNum;
        for (let i = 0; i < that.elemCount; i++) {
            sum += '<span class="sim-dot"></span>'
        }
        that.indicatorDots.innerHTML = sum;
        that.indicatorDotsAll = that.sldrRoot.querySelectorAll('span.sim-dot');
        for (let n = 0; n < that.elemCount; n++) {
            that.indicatorDotsAll[n].addEventListener('click', function () {
                diffNum = Math.abs(n - that.currentElement);
                if (n < that.currentElement) {
                    bgTime = getTime();
                    that.elemPrev(diffNum)
                }
                else if (n > that.currentElement) {
                    bgTime = getTime();
                    that.elemNext(diffNum)
                }
            }, false)
        }
        that.dotOff(0);
        for (let i = 1; i < that.elemCount; i++) {
            that.dotOn(i)
        }
    }
};

new Sim('slider-top', true, true, 10000, false, true);
new Sim('slider-bottom', true, false, 0, true, false);

//Слайдер для карточек
var multiItemSlider = (function () {
    return function (selector, config) {
        var
            _mainElement = document.querySelector(selector),
            _sliderWrapper = _mainElement.querySelector('.slider__wrapper'),
            _sliderItems = _mainElement.querySelectorAll('.slider__item'),
            _sliderControls = _mainElement.querySelectorAll('.slider__control'),
            _sliderControlLeft = _mainElement.querySelector('.slider__control_left'),
            _sliderControlRight = _mainElement.querySelector('.slider__control_right'),
            _wrapperWidth = parseFloat(getComputedStyle(_sliderWrapper).width),
            _itemWidth = parseFloat(getComputedStyle(_sliderItems[0]).width),
            _positionLeftItem = 0,
            _transform = 0,
            _step = _itemWidth / _wrapperWidth * 100,
            _items = [];

        _sliderItems.forEach(function (item, index) {
            _items.push({item: item, position: index, transform: 0});
        });

        var position = {
            getItemMin: function () {
                var indexItem = 0;
                _items.forEach(function (item, index) {
                    if (item.position < _items[indexItem].position) {
                        indexItem = index;
                    }
                });
                return indexItem;
            },
            getItemMax: function () {
                var indexItem = 0;
                _items.forEach(function (item, index) {
                    if (item.position > _items[indexItem].position) {
                        indexItem = index;
                    }
                });
                return indexItem;
            },
            getMin: function () {
                return _items[position.getItemMin()].position;
            },
            getMax: function () {
                return _items[position.getItemMax()].position;
            }
        }

        var _transformItem = function (direction) {
            var nextItem;
            if (direction === 'right') {
                _positionLeftItem++;
                if ((_positionLeftItem + _wrapperWidth / _itemWidth - 1) > position.getMax()) {
                    nextItem = position.getItemMin();
                    _items[nextItem].position = position.getMax() + 1;
                    _items[nextItem].transform += _items.length * 100;
                    _items[nextItem].item.style.transform = 'translateX(' + _items[nextItem].transform + '%)';
                }
                _transform -= _step;
            }
            if (direction === 'left') {
                _positionLeftItem--;
                if (_positionLeftItem < position.getMin()) {
                    nextItem = position.getItemMax();
                    _items[nextItem].position = position.getMin() - 1;
                    _items[nextItem].transform -= _items.length * 100;
                    _items[nextItem].item.style.transform = 'translateX(' + _items[nextItem].transform + '%)';
                }
                _transform += _step;
            }
            _sliderWrapper.style.transform = 'translateX(' + _transform + '%)';
        }

        var _controlClick = function (e) {
            if (e.target.classList.contains('slider__control')) {
                e.preventDefault();
                var direction = e.target.classList.contains('slider__control_right') ? 'right' : 'left';
                _transformItem(direction);
            }
        };

        var _setUpListeners = function () {
            _sliderControls.forEach(function (item) {
                item.addEventListener('click', _controlClick);
            });
        }


        _setUpListeners();

        return {
            right: function () {
                _transformItem('right');
            },
            left: function () {
                _transformItem('left');
            }
        }

    }
}());

var slider1 = multiItemSlider('.slider-first')
var slider2 = multiItemSlider('.slider-second')

function plus(id, price) {
    let v = document.getElementById("val" + id);
    if (v.innerText < 100) {
        var xmlhttp = getXmlHttp();
        xmlhttp.open('POST', '/site/add-to-cart?id=' + encodeURIComponent(id), true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send();
        v.innerText = parseInt(v.innerText) + 1;
        let finish = document.getElementById("finish");
        finish.innerText = parseInt(price) + parseInt(finish.innerText);
    }
}

function add(id) {
    var xmlhttp = getXmlHttp();
    xmlhttp.open('POST', '/site/add-to-cart?id=' + encodeURIComponent(id), true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
    let finish1 = document.getElementById("span1");
    finish1.innerText = parseInt(finish1.innerText) + 1;
    let finish = document.getElementById("span2");
    finish.innerText = parseInt(finish.innerText) + 1;
}

function minus(id, count, price) {
    let v = document.getElementById("val" + id);
    if (v.innerText > count) {
        var xmlhttp = getXmlHttp();
        xmlhttp.open('POST', '/site/sub-from-cart?id=' + encodeURIComponent(id), true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send();
        v.innerText -= 1;
        let finish = document.getElementById("finish");
        finish.innerText = parseInt(finish.innerText) - parseInt(price);
    }
}

function id_delete(id, count) {
    let v = document.getElementById("val" + id);
    var data = {};
    data['id'] = id;
    data['count'] = count;
    $.ajax({
        url: '/site/sub-from-cart',
        data: data,
    });
}

function getXmlHttp() {
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function updateCount(id, price) {

}

$(function () {
    $('.slick-vertical').slick({
        vertical: true,
        verticalSwiping: true,
        slidesToShow: 3,
        autoplay: true,
        prevArrow: '<img src="/images/up.svg">',
        nextArrow: '<img src="/images/down.svg">'
    });
});

$('.form-radio').change(function () {
    $('.inactive-button').removeClass('inactive-button');
    document.getElementsByClassName('radio-button').addClass('inactive-button');
});