// introduced by Xenor in 2023: make the background page unscrollable while the nav overlay is open
document.getElementById("nav-state").addEventListener('change', function() {
    document.getElementsByTagName("body")[0].style = "overflow: " + (this.checked? "hidden" : "auto") + ";"
})