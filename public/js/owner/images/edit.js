"use strict";

{
  document.querySelector(".delete-form").addEventListener("submit", (e) => {
    e.preventDefault();
    if (
      !confirm(
        "商品側でその画像を使用していた場合、一緒に削除されますがよろしいでしょうか？"
      )
    ) {
      return;
    }
    e.target.submit();
  });
}
