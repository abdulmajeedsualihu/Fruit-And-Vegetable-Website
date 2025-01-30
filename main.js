
document.addEventListener("DOMContentLoaded", function () {

    var scrollLinks = document.querySelectorAll('.smooth-scroll')

    scrollLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault()

            var targetId = this.getAttribute('href').substr(1)
            var targetElement = document.getElementById(targetId)

            if (targetElement) {

                var targetOffset = targetElement.offsetTop;
                var currentOffset = window.pageYOffset;
                var distance = targetOffset - currentOffset;
                var duration = 800; // Animation duration in milliseconds
                var start;

                function step(timestamp) {
                    if (!start) start = timestamp;
                    var progress = timestamp - start;
                    var percentage = Math.min(progress / duration, 1);
                    window.scrollTo(0, currentOffset + distance * percentage);
                    if (progress < duration) {
                        window.requestAnimationFrame(step);
                    }

                }

            }
            window.requestAnimationFrame(step);
        })
    })

})

function tabAnimation(x) {

    const allTabs = document.querySelectorAll(".tab-pane")
    allTabs.forEach(function (x) {
        x.style.opacity = "0"
    })

    const tab = document.getElementById(x)
    tab.style.opacity = 1
    tab.style.transition = "0.5s"

}