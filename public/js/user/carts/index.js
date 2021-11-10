"use strict";
{
  document.querySelectorAll(".delete").forEach((deleteForm, index) => {
    deleteForm.addEventListener("submit", (e) => {
      e.preventDefault();
      if (!confirm("本当に削除してもいいですか?")) {
        return;
      }
      e.target.submit();
    });
  });
}
