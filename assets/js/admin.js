document.addEventListener("DOMContentLoaded", function () {
  jQuery(".mk-marquee-color-picker").wpColorPicker()

  const sourceSelect = document.querySelector(
    '[name="mk_simple_marquee_options[source]"]',
  )
  const customTextContainer = document.getElementById(
    "mk_simple_marquee_custom_text_container",
  )

  function toggleCustomText() {
    if (!sourceSelect || !customTextContainer) return

    const isCustom = sourceSelect.value === "custom"
    customTextContainer.style.display = isCustom ? "block" : "none"
  }

  if (sourceSelect) {
    toggleCustomText()
    sourceSelect.addEventListener("change", toggleCustomText)
  }
})
