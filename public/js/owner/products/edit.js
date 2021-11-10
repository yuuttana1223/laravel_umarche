"use strict";

{
  const selectButtons = document.querySelectorAll("a[href='javascript:;']");

  selectButtons.forEach((selectBtn, index) => {
    selectBtn.addEventListener("click", (e) => {
      const input = e.target.nextElementSibling;
      // モーダル出現
      document.querySelectorAll(".image").forEach((modalImage) => {
        modalImage.onclick = (e) => {
          input.value = e.target.dataset.id;
          const selectImage = document.createElement("img");
          selectImage.src = modalImage.src;
          selectImage.className = "p-2 border rounded-md md:p-4 md:pb-6";
          const imageParent = document.getElementById(`image-wrap${index + 1}`);
          imageParent.innerHTML = "";
          imageParent.appendChild(selectImage);
          MicroModal.close();
        };
      });
    });
  });

  document.querySelectorAll(".delete-image").forEach((deleteImage, index) => {
    deleteImage.addEventListener("click", (e) => {
      e.target.previousElementSibling.innerHTML = "";
      document.querySelector(`input[name=image${index + 1}]`).value = "";
    });
  });

  const increaseWord = "現在の在庫から増やす数量";
  const decreaseWord = "現在の在庫から減らす数量";
  const typeButtons = document.querySelectorAll("input[name='type']");
  const quantityLabel = document.querySelector("label[for='quantity']");
  quantityLabel.innerText = typeButtons[0].checked
    ? increaseWord
    : decreaseWord;
  console.log(typeButtons[0].value);
  typeButtons.forEach((typeButton) => {
    typeButton.addEventListener("click", (e) => {
      switch (e.target.value) {
        case "1":
          quantityLabel.innerText = increaseWord;
          break;
        case "2":
          quantityLabel.innerText = decreaseWord;
          break;
      }
    });
  });

  document.querySelector(".delete-form").addEventListener("submit", (e) => {
    e.preventDefault();
    if (!confirm("本当に削除してもいいですか?")) {
      return;
    }
    e.target.submit();
  });
}
