$(document).ready(() => {
    const navLinks = document.querySelectorAll(".nav-link");

        navLinks.forEach(link => {
            link.addEventListener("click", function (e) {
                // Bỏ class active khỏi tất cả các link
                navLinks.forEach(link => link.classList.remove("active"));

                // Thêm class active cho link được click
                this.classList.add("active");
            });
        });
}); 