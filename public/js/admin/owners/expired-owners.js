"use strict";

{
  const deleteForms = document.querySelectorAll(".delete-form");
  deleteForms.forEach((deleteForm) => {
    deleteForm.addEventListener("submit", (e) => {
      e.preventDefault();
      if (!confirm("本当に削除してもいいですか?")) {
        return;
      }
      deleteForm.submit();
    });
  });
}
