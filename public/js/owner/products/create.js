"use strict";
{
  const selectButtons = document.querySelectorAll("a[href='javascript:;']");

  selectButtons.forEach((selectBtn, index) => {
    selectBtn.addEventListener("click", (e) => {
      const input = e.target.nextElementSibling;
      // モーダル出現
      document.querySelectorAll(".image").forEach((modalImage) => {
        // イベントを上書き(addEventListenerだと無限にイベントが追加されていく)
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
}
