document.addEventListener("DOMContentLoaded", function () {
  const mkMarquee = document.querySelector(".mk-marquee")
  if (!mkMarquee) return

  const isMobile = window.innerWidth < 768
  const mobileBehavior = mkMarquee.getAttribute("data-mk-marquee-mobile")
  if (mobileBehavior === "off-mobile" && isMobile) {
    mkMarquee.remove()
    return
  }

  const mkMarqueeWrapper = mkMarquee.querySelector(".mk-marquee__wrapper")
  const mkMarqueeContent = mkMarquee.querySelector(".mk-marquee__content")

  if (
    !mkMarqueeContent ||
    !mkMarqueeContent.textContent.trim() ||
    mkMarqueeContent.children.length === 0
  ) {
    mkMarquee.remove()
    return
  }

  function getAttr(attr, defaultValue) {
    const value = mkMarquee.getAttribute(attr)
    return value ? value.trim() : defaultValue
  }

  function getNumberAttr(attr, defaultValue) {
    const value = parseInt(getAttr(attr, defaultValue))
    return isNaN(value) ? defaultValue : value
  }

  const mkScrollSpeed = getNumberAttr("data-mk-marquee-speed", 200)
  const mkMarqueeBgColor = getAttr("data-mk-marquee-bg-color", "#000")
  const mkMarqueeTextColor = getAttr("data-mk-marquee-text-color", "#FFF")
  const mkMarqueeFontSize =
    getNumberAttr("data-mk-marquee-font-size", 16) + "px"
  const mkMarqueeHeight = getNumberAttr("data-mk-marquee-height", 50) + "px"
  const mkMarqueeHoverPause =
    getAttr("data-mk-marquee-hover-pause", "false") === "true"
  const mkMarqueePosition = getAttr("data-mk-marquee-position", "bottom")

  mkMarquee.style.setProperty("--mk-marquee-bg-color", mkMarqueeBgColor)
  mkMarquee.style.setProperty("--mk-marquee-text-color", mkMarqueeTextColor)
  mkMarquee.style.setProperty("--mk-marquee-font-size", mkMarqueeFontSize)
  mkMarquee.style.setProperty("--mk-marquee-height", mkMarqueeHeight)

  const extraPadding = 10
  if (mkMarqueePosition === "top") {
    mkMarquee.style.top = "0"
    document.body.style.paddingTop =
      parseInt(mkMarqueeHeight) + extraPadding + "px"
  } else {
    mkMarquee.style.bottom = "0"
    document.body.style.paddingBottom =
      parseInt(mkMarqueeHeight) + extraPadding + "px"
  }

  if (mkMarqueeHoverPause) {
    mkMarquee.classList.add("mk-marquee--pause-on-hover")
  }

  function extendContent() {
    const contentWidth = mkMarqueeContent.scrollWidth
    const wrapperWidth = mkMarquee.offsetWidth

    const items = mkMarqueeContent.querySelectorAll("li")

    if (items.length === 1) {
      const li = items[0]
      const originalText = li.textContent.trim()
      let repeatCount = 2
      const parts = [originalText]

      while (li.scrollWidth < mkMarquee.offsetWidth && repeatCount < 20) {
        parts.push(originalText)
        repeatCount++
      }

      li.textContent = "\u00A0" + parts.join(" \u00A0") + "\u00A0"
    } else {
      let repeatCount = 1
      const originalHTML = mkMarqueeContent.innerHTML

      while (
        mkMarqueeContent.scrollWidth < wrapperWidth * 2 &&
        repeatCount < 20
      ) {
        mkMarqueeContent.innerHTML += originalHTML
        repeatCount++
      }
    }
  }

  extendContent()

  const mkDuplicateContent = mkMarqueeContent.cloneNode(true)
  mkDuplicateContent.setAttribute("aria-hidden", "true")
  mkMarqueeWrapper.appendChild(mkDuplicateContent)

  function calculateSpeed() {
    const contentWidth = mkMarqueeContent.scrollWidth
    const totalDistance = contentWidth * 2
    const animationDuration = totalDistance / mkScrollSpeed
    mkMarquee.style.setProperty("--mk-marquee-speed", `${animationDuration}s`)
  }

  calculateSpeed()

  new MutationObserver(() => {
    extendContent()
    calculateSpeed()
  }).observe(mkMarqueeContent, {
    childList: true,
    subtree: true,
  })
})
