<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
.scroll-btn {
    width: 45px;
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: none;
    background-color: black;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
}
.show {
    display: block;
}
</style>
<body>
    
</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const scrollBtn = document.getElementById("scrollBtn");
    
    window.addEventListener("scroll", function() {
        if (window.scrollY > 100) {
            scrollBtn.classList.add("show");
        } else {
            scrollBtn.classList.remove("show");
        }
    });
    
    scrollBtn.addEventListener("click", function() {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});
</script>

<button id="scrollBtn" class="scroll-btn">
    <i class="fas fa-arrow-up"></i>
</button>
</html>