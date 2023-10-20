document.addEventListener("DOMContentLoaded", function() {
    
    // この関数は外部で定義しても大丈夫です。
    function updateGrandTotals() {
        const resultElements = document.querySelectorAll('.result');
        const resultWithTaxElements = document.querySelectorAll('.result2');
    
        let grandTotal = 0;
        let grandTotalWithTax = 0;
    
        resultElements.forEach(el => {
            const value = parseFloat(el.textContent) || 0;
            grandTotal += value;
        });
    
        resultWithTaxElements.forEach(el => {
            const value = parseFloat(el.textContent) || 0;
            grandTotalWithTax += value;
        });
    
        const grandTotalElement = document.querySelector('#grandtotal');
        const grandTotalWithTaxElement = document.querySelector('#grandtotaltax');
    
        grandTotalElement.textContent = Math.round(grandTotal) + '円';
        grandTotalWithTaxElement.textContent = Math.round(grandTotalWithTax) + '円';
        
    }
    
    const inputElements = document.querySelectorAll('input[type="number"]');
    
    inputElements.forEach(function(input) {
        input.addEventListener('input', function(e) {
            const productId = e.target.getAttribute('data-product-id');
            const priceElement = document.querySelector('#price_' + productId);
            const stockElement = document.querySelector('#stock_' + productId);
            const resultElement = document.querySelector('#result_' + productId);
            const resultWithTaxElement = document.querySelector('#result2_' + productId);

            const originalStock = parseInt(stockElement.getAttribute('data-original-stock'), 10);
            const price = parseFloat(priceElement.textContent);
            const quantity = parseInt(e.target.value, 10);

            if (isNaN(quantity) || quantity <= 0) {
                stockElement.textContent = originalStock;
                resultElement.textContent = '';
                resultWithTaxElement.textContent = '';
                return;
            }

            const remainingStock = originalStock - quantity;

            if (remainingStock < 0) {
                stockElement.textContent = "0"; // 在庫数を0に
                resultElement.textContent = '在庫ぎれ';
                resultWithTaxElement.textContent = '';
                return;
            }

            stockElement.textContent = remainingStock;

            const subtotal = Math.round(price * quantity);
            const subtotalWithTax = Math.round(subtotal * 1.08);

            resultElement.textContent = subtotal + '円';
            resultWithTaxElement.textContent = subtotalWithTax + '円';

            updateGrandTotals(); // ここで関数を呼び出しています。
        });
    });
});
