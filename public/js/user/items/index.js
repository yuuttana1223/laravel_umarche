"use strict";
{
  const form = document.getElementById("select-form");

  document.getElementById("sort").addEventListener("change", () => {
    form.submit();
  });

  document.getElementById("pagination").addEventListener("change", () => {
    form.submit();
  });
}
