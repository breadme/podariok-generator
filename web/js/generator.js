"use strict";

let history = [];
let generatorCounter = 0;
let giftItem = null;
let xDown = null;
let xDiff = null;
let totalX = screen.width;
let mouseStatus = false;
let giftId = 0;

function getCsrf() {
    return $('meta[name="csrf-token"]').attr("content");
}

function getGift(data = false) {

    let formData = new FormData();
    formData.append('key', generatorKey);

    if (data) {
        setGiftBlock(data);
    } else {
        fetch('/generator/get-gift', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': getCsrf()
            },
            body: new URLSearchParams(formData)
        })
            .then(
                function (response) {
                    response.json().then(function (data) {
                        setGiftBlock(data);
                    });
                }
            );
    }
}

getGift();

function setGiftBlock(data) {
    let giftBlock = document.createElement('div');
    giftBlock.className = 'block-4 generator-gift';
    document.getElementById("generator-gift-list").append(giftBlock);
    initGift();
    cleanGiftParams();
    giftItem.innerHTML = data.content;
    giftId = data.id;
}

function checkResult(id, result) {
    let formData = new FormData();
    formData.append('key', generatorKey);
    formData.append('id', id);
    formData.append('result', result);


    if (history.indexOf(id) == -1) {
        history.push(id);
        fetch('/generator/check-result', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': getCsrf()
            },
            body: new URLSearchParams(formData)
        })
            .then(
                function (response) {
                    response.json().then(function (data) {
                        document.getElementsByClassName('generator-counter-element')[generatorCounter++]
                            .classList.add(parseInt(result) ? 'active-green' : 'active-red');
                        document.getElementById('generator-counter-value-now').innerHTML = generatorCounter;
                        if (data.result == false) {
                            getGift(data.content);
                        } else {
                            document.getElementById('generator-block').remove();
                            document.getElementById('generator-result').innerHTML = data.content;
                        }
                    });
                }
            );
    }
}

function cleanGiftParams() {
    giftItem.style.transform = 'rotate(0) translateX(0)';
    giftItem.classList.remove("animate-left");
    giftItem.classList.remove("animate-right");
}

function initGift() {
    let giftItemTemp = document.getElementsByClassName('generator-gift');
    giftItem = giftItemTemp[giftItemTemp.length - 1];
    giftItem.addEventListener('touchstart', handleTouchStart, false);
    giftItem.addEventListener('touchmove', handleTouchMove, false);
    giftItem.addEventListener('touchend', handleTouchEnd, false);
    document.addEventListener('mousedown', mouseTouchStart, false);
    document.addEventListener('mousemove', mouseTouchMove, false);
    document.addEventListener('mouseup', handleTouchEnd, false);
}

function deleteGift() {
    document.getElementsByClassName('generator-gift')[0].remove();
}

Array.from(document.getElementsByClassName("generator-btn")).forEach(function (element) {
    element.addEventListener('click', function (e) {
        let giftItemTemp = document.getElementsByClassName('generator-gift');
        if (giftItemTemp.length == 1) {
            hideGiftAnimate(parseInt(e.target.dataset.value));
            checkResult(giftId, e.target.dataset.value);
        }
    });
});


function handleTouchStart(evt) {
    totalX = screen.width;
    xDown = evt.touches[0].clientX;
    giftItem.classList.add('on-move');
}

function mouseTouchStart(evt) {
    totalX = screen.width;
    xDown = evt.pageX;
    mouseStatus = true;
    giftItem.classList.add('on-move');
}

function handleTouchEnd() {
    giftItem.classList.remove('on-move');
    let resultForCheck = ((xDiff / totalX) * 100);
    let sizeForCheck = totalX > 900 ? 5 : 10;
    let giftItemTemp = document.getElementsByClassName('generator-gift');
    if (giftItemTemp.length == 1) {
        if (Math.abs(resultForCheck) < sizeForCheck) {
            cleanGiftParams();
        } else {
            hideGiftAnimate(resultForCheck);
            checkResult(giftId, resultForCheck > 0 ? 0 : 1);
        }
    }
    mouseStatus = false;
    xDown = null;
    xDiff = null;
}

function handleTouchMove(evt) {
    let xUp = evt.touches[0].clientX;
    giftMove(xUp);

}

function mouseTouchMove(evt) {
    if (mouseStatus) {
        let xUp = evt.pageX;
        giftMove(xUp);
    }
}

function giftMove(xUp) {
    xDiff = xDown - xUp;
    let size = totalX > 900 ? -400 : -30;
    giftItem.style.transform = 'rotate(' + (-5 * xDiff / totalX) + 'deg) translateX(' + (size * xDiff / totalX) + 'px)';
}

function hideGiftAnimate(checkResult) {
    let animateVector = checkResult > 0 ? 'right' : 'left';
    giftItem.classList.add("animate-" + animateVector);
    setTimeout(deleteGift, 500);
}

