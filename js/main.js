document.addEventListener('DOMContentLoaded', function() {
    
    // --- ADD TO CART LOGIC ---
    const addToCartForm = document.getElementById('addToCartForm');
    
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Stop the page from refreshing
            
            const submitBtn = addToCartForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Adding...';
            submitBtn.disabled = true;

            const formData = new FormData(addToCartForm);

            fetch('ajax_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    submitBtn.innerHTML = 'Added to Trousseau';
                    submitBtn.style.backgroundColor = 'var(--emerald)';
                    // Update cart count in the navigation bar
                    document.querySelector('.nav-links a[href*="cart.php"]').innerHTML = `Cart (${data.cart_count})`;
                } else {
                    alert(data.message);
                    submitBtn.innerHTML = originalText;
                }
                setTimeout(() => { 
                    submitBtn.innerHTML = originalText; 
                    submitBtn.disabled = false;
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.innerHTML = 'Error. Try Again.';
                submitBtn.disabled = false;
            });
        });
    }

    // --- CART PAGE LOGIC ---

    // 1. Handle Quantity Changes
    document.querySelectorAll('.cart-qty-input').forEach(input => {
        input.addEventListener('change', function() {
            const key = this.dataset.key;
            const qty = this.value;
            updateCartItem(key, qty);
        });
    });

    // 2. Handle Item Removal
    document.querySelectorAll('.remove-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const key = this.dataset.key;
            updateCartItem(key, 0); // Sending 0 tells the server to delete the item
        });
    });

    // The AJAX function that talks to the server
    function updateCartItem(key, qty) {
        const formData = new FormData();
        formData.append('key', key);
        formData.append('qty', qty);

        fetch('ajax_update_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Refresh the page to reflect new subtotals and shipping logic
                window.location.reload(); 
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});