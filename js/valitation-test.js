var nameInput = document.querySelector('.name');
var nameError = document.querySelector('.nameError');

nameInput.addEventListener('blur', function() {
  if (nameInput.value === '') {
    nameError.textContent = '※入力してください';
    nameInput.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
  } else {
    nameError.textContent = '';
    nameInput.style.backgroundColor = 'white';
  }
});

var telInput = document.querySelector('.tell');
var telError = document.querySelector('.telError');

telInput.addEventListener('blur', function() {
  if (telInput.value === '') {
    telError.textContent = '※入力してください';
    telInput.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
  } else {
    telError.textContent = '';
    telInput.style.backgroundColor = 'white'; 
  }
});

var telInput = document.querySelector('.tell');
var telError = document.querySelector('.telError');

telInput.addEventListener('input', function() {
  var telValue = telInput.value.replace(/[^\d]/g, ''); // 数字以外の文字を削除

  if (telValue.length < 9) {
    telError.textContent = '※9桁から11桁で入力してください';
    telError.style.display = 'block'; // エラーメッセージを表示
  } else if (telValue.length >= 9 && telValue.length <= 11) {
    telError.textContent = '';
    telError.style.display = 'none'; // エラーメッセージを非表示
  }
});

var zipInput1 = document.querySelector('input[name="zip21"]');
var zipInput2 = document.querySelector('input[name="zip22"]');
var addressError = document.querySelector('.addressError');
var prefInput = document.querySelector('input[name="pref21"]');
var addrInput = document.querySelector('input[name="addr21"]');
var strtInput = document.querySelector('input[name="strt21"]');

zipInput1.addEventListener('blur', function() {
  if (zipInput1.value === '' && zipInput2.value === '') {
    addressError.textContent = '※郵便番号を入力してください';
    zipInput1.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
    zipInput2.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
    prefInput.disabled = true;
    addrInput.disabled = true;
    strtInput.disabled = true;
  } else {
    addressError.textContent = '';
    zipInput1.style.backgroundColor = 'white';
    zipInput2.style.backgroundColor = 'white';
    prefInput.disabled = false;
    addrInput.disabled = false;
    strtInput.disabled = false;
  }
});


var addressInput = document.querySelector('.wi20');
var addressError = document.querySelector('.addressError');

addressInput.addEventListener('blur', function() {
  if (addressInput.value === '') {
    addressError.textContent = '※入力してください';
    addressInput.style.backgroundColor = 'rgba(255, 0, 0, 0.2)'; // 背景色を薄い赤に設定
  } else {
    addressError.textContent = '';
    addressInput.style.backgroundColor = 'white'; // 背景色を白に設定
  }
});

var passInput = document.querySelector('.input_pass');
var passError = document.querySelector('.passError');

passInput.addEventListener('blur', function() {
  if (passInput.value === '') {
    passError.textContent = '※入力してください';
    passInput.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
  } else {
    passError.textContent = '';
    passInput.style.backgroundColor = 'white'; 
  }
});

passInput.addEventListener('input', function() {
  var passValue = passInput.value;
  
  if (passValue.length < 8 || passValue.length > 10 || !passValue.match(/^[a-zA-Z0-9]+$/)) {
    passError.textContent = '※半角英数字8~10文字で入力してください';
    passError.style.display = 'block'; // エラーメッセージを表示
  } else {
    passError.textContent = '';
    passError.style.display = 'none'; // エラーメッセージを非表示
  }
});

function checkForm() {
  var input1 = document.getElementById('input1').value;
  var input2 = document.getElementById('input2').value;

  if (input1 === '' || input2 === '') {
    window.open('', 'popup', 'width=200,height=100');
    var popupContent = document.createElement('p');
    popupContent.innerHTML = '入力をしてください';
    window.document.body.appendChild(popupContent);
  }
}

$(function(){
  $('.btn').on('click', function(){
    if($('.name').val() === ''){
      alert('名前を入力してください！');
      $(this).focus();
      return false;
    }
    alert('送信完了！');
  });
});


