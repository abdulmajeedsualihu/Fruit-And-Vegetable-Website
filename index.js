document.addEventListener("DOMContentLoaded", () => {
    const cartButtons = document.querySelectorAll(".add-to-cart");

    cartButtons.forEach(button => {
        button.addEventListener("click", () => {
            const productId = button.getAttribute("data-id");

            // Check if user is logged in
            fetch("check-login.php")
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        addToCart(productId);
                    } else {
                        alert("You must log in to add products to your cart.");
                        window.location.href = "login.php";
                    }
                })
                .catch(error => console.error("Error checking login:", error));
        });
    });

    function addToCart(productId) {
        fetch("add-to-cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Product added to cart!");
            } else {
                alert("Error adding product to cart.");
            }
        })
        .catch(error => console.error("Error adding to cart:", error));
    }
});
