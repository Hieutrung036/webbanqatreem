document.addEventListener("DOMContentLoaded", function () {
    var successAlert = document.getElementById("success-alert");

    if (successAlert) {
        console.log("Thông báo hiện, sẽ tự động tắt sau 10 giây.");

        // Tự động ẩn sau 10 giây
        setTimeout(function () {
            // Xóa class 'show' để bắt đầu ẩn dần
            successAlert.classList.remove("show");

            // Sau khi hoàn tất hiệu ứng, ẩn hoàn toàn
            setTimeout(function () {
                successAlert.style.display = "none";
            }, 500); // Khoảng thời gian ngắn để khớp với hiệu ứng CSS
        }, 5000); // Tự động ẩn sau 10 giây
    }
});

document.addEventListener("DOMContentLoaded", function () {
    var errorPopup = document.getElementById("error-popup");
    if (errorPopup) {
        setTimeout(function () {
            errorPopup.style.display = "none";
        }, 10000); // 10 giây
    }
});

document.addEventListener("DOMContentLoaded", function () {
    var errorAlert = document.getElementById("error-alert");

    if (errorAlert) {
        console.log("Thông báo hiện, sẽ tự động tắt sau 10 giây.");

        // Tự động ẩn sau 10 giây
        setTimeout(function () {
            // Xóa class 'show' để bắt đầu ẩn dần
            errorAlert.classList.remove("show");

            // Sau khi hoàn tất hiệu ứng, ẩn hoàn toàn
            setTimeout(function () {
                errorAlert.style.display = "none";
            }, 500); // Khoảng thời gian ngắn để khớp với hiệu ứng CSS
        }, 5000); // Tự động ẩn sau 10 giây
    }
});

$(document).ready(function () {
    $("#btnToggle").hover(function () {
        $("#infoContainer").toggle();
    });
});

document.querySelectorAll(".size-box").forEach((box) => {
    box.addEventListener("click", function () {
        // Bỏ lớp 'selected' khỏi tất cả các ô
        document
            .querySelectorAll(".size-box")
            .forEach((item) => item.classList.remove("selected"));
        // Thêm lớp 'selected' vào ô được chọn
        this.classList.add("selected");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Xử lý khi chọn màu
    document.querySelectorAll(".color-option").forEach(function (button) {
        button.addEventListener("click", function () {
            document
                .querySelectorAll(".color-option")
                .forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");
            const selectedColor = this.getAttribute("data-color");
            console.log("Selected color ID:", selectedColor); // Để kiểm tra ID của màu được chọn
        });
    });

    // Xử lý khi chọn kích thước
    document.querySelectorAll(".size-option").forEach(function (button) {
        button.addEventListener("click", function () {
            document
                .querySelectorAll(".size-option")
                .forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");
            const selectedSize = this.getAttribute("data-size");
            console.log("Selected size ID:", selectedSize); // Để kiểm tra ID của kích thước được chọn
        });
    });
});

// Cập nhật giá trị hiddenQuantityInput khi số lượng thay đổi





jQuery(document).ready(function ($) {
    $("#selectDiaChi").on("change", function () {
        const selectedOption = $(this).find(":selected");

        // Cập nhật các trường thông tin giao hàng
        $("#tennguoinhan").val(selectedOption.data("tennguoinhan"));
        $("#sdt").val(selectedOption.data("sdt"));
        $("#diachi").val(selectedOption.data("diachi"));
        $("#phuongxa").val(selectedOption.data("phuongxa"));
        $("#quanhuyen").val(selectedOption.data("quanhuyen"));
        $("#tinhthanhpho").val(selectedOption.data("tinhthanhpho"));

        // Cập nhật giá trị cho input ẩn iddc
        const iddcValue = selectedOption.val();
        $("#iddc").val(iddcValue); // Cập nhật iddc vào input ẩn
        console.log("Selected iddc:", iddcValue); // Kiểm tra giá trị iddc
    });
});

jQuery(document).ready(function ($) {
    $("#phuongthucvanchuyen").on("change", function () {
        const selectedOption = $(this).find(":selected");
        const phigiaohang = selectedOption.data("phuongthucgiaohang");

        // Kiểm tra nếu phigiaohang là số hợp lệ
        if (!isNaN(phigiaohang) && phigiaohang !== undefined) {
            const formattedPhigiaohang =
                Number(phigiaohang).toLocaleString("vi-VN");
            $("#phigiaohang").text(formattedPhigiaohang + " VND");

            // Lấy tổng tiền từ hidden input
            const tongTien = parseFloat($("#tongTien").data("tong-tien"));
            if (!isNaN(tongTien)) {
                const tongTienShip = tongTien + parseFloat(phigiaohang);
                const formattedTongTienShip =
                    tongTienShip.toLocaleString("vi-VN");
                $("#tongTienShip").text(formattedTongTienShip + " VND");
            } else {
                $("#tongTienShip").text("Tổng tiền không hợp lệ");
            }
        } else {
            $("#phigiaohang").text("Phí giao hàng không hợp lệ");
            $("#tongTienShip").text("Tổng tiền không hợp lệ");
        }
    });
});

$(document).ready(function () {
    // Cập nhật giá trị phương thức vận chuyển
    $("#phuongthucvanchuyen").change(function () {
        var phuongthucvanchuyen = $(this).val();
        $("#phuongthucvanchuyen_hidden").val(phuongthucvanchuyen);
    });

    // Cập nhật mã giảm giá
    $("#maVoucher").change(function () {
        var voucherCode = $(this).val();
        $("#voucherCode_hidden").val(voucherCode);
    });

    // Cập nhật tổng tiền (nếu cần)
    $("#tongTien").change(function () {
        var tongTien = $(this).val();
        $("#tongTien_hidden").val(tongTien);
    });
});


$(document).ready(function() {
    $('#short').change(function() {
        const orderBy = $(this).val();
        
        // Kiểm tra chế độ hiển thị hiện tại
        const activeTab = $(".tab-pane.show.active").attr("id");

        // Chọn container sản phẩm dựa trên chế độ hiển thị
        let productsContainer;
        if (activeTab === "large") {
            productsContainer = $('#product-list-grid');
        } else if (activeTab === "list") {
            productsContainer = $('#product-list-list');
        }

        const products = Array.from(productsContainer.find('.product-item'));

        products.sort(function(a, b) {
            const nameA = $(a).find(".product_title").text().trim();
            const nameB = $(b).find(".product_title").text().trim();
            const priceA = parseFloat($(a).find(".product_content span").text().replace(/[^0-9]/g, ""));
            const priceB = parseFloat($(b).find(".product_content span").text().replace(/[^0-9]/g, ""));
            const idA = parseInt($(a).data('id'));
            const idB = parseInt($(b).data('id'));

            switch (orderBy) {
                case "newest":
                    return idB - idA; // Sắp xếp theo id giảm dần (Mới nhất)
                case "oldest":
                    return idA - idB; // Sắp xếp theo id tăng dần (Cũ nhất)
                case "price_asc":
                    return priceA - priceB; // Sắp xếp theo giá từ thấp đến cao
                case "price_desc":
                    return priceB - priceA; // Sắp xếp theo giá từ cao đến thấp
                case "name_asc":
                    return nameA.localeCompare(nameB); // Sắp xếp theo tên A-Z
                case "name_desc":
                    return nameB.localeCompare(nameA); // Sắp xếp theo tên Z-A
                default:
                    return 0;
            }
        });

        // Xóa và thêm lại các sản phẩm đã sắp xếp
        productsContainer.empty();
        products.forEach(function(product) {
            productsContainer.append(product);
        });
    });
});


$(document).ready(function() {
    $('#short').change(function() {
        const orderBy = $(this).val();
        
        // Kiểm tra chế độ hiển thị hiện tại
        const activeTab = $(".tab-pane.show.active").attr("id");

        // Chọn container sản phẩm dựa trên chế độ hiển thị
        let productsContainer;
        if (activeTab === "large") {
            productsContainer = $('#product-list-grid');
        } else if (activeTab === "list") {
            productsContainer = $('#product-list-list');
        }

        const products = Array.from(productsContainer.find('.product-item'));

        products.sort(function(a, b) {
            const nameA = $(a).find(".list_title").text().trim();
            const nameB = $(b).find(".list_title").text().trim();
            const priceA = parseFloat($(a).find(".content_price span").text().replace(/[^0-9]/g, ""));
            const priceB = parseFloat($(b).find(".content_price span").text().replace(/[^0-9]/g, ""));
            const idA = parseInt($(a).data('id'));
            const idB = parseInt($(b).data('id'));

            switch (orderBy) {
                case "newest":
                    return idB - idA; // Sắp xếp theo id giảm dần (Mới nhất)
                case "oldest":
                    return idA - idB; // Sắp xếp theo id tăng dần (Cũ nhất)
                case "price_asc":
                    return priceA - priceB; // Sắp xếp theo giá từ thấp đến cao
                case "price_desc":
                    return priceB - priceA; // Sắp xếp theo giá từ cao đến thấp
                case "name_asc":
                    return nameA.localeCompare(nameB); // Sắp xếp theo tên A-Z
                case "name_desc":
                    return nameB.localeCompare(nameA); // Sắp xếp theo tên Z-A
                default:
                    return 0;
            }
        });

        // Xóa và thêm lại các sản phẩm đã sắp xếp
        productsContainer.empty();
        products.forEach(function(product) {
            productsContainer.append(product);
        });
    });
});


document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        filterProducts();
    });
});

function filterProducts() {
    let products = document.querySelectorAll('.product-item');

    let selectedCategories = [];
    let selectedBrands = [];
    let selectedSizes = [];
    let selectedColor = [];
    let selectedPriceRanges = [];

    // Lấy giá trị từ checkbox
    document.querySelectorAll('.filter-checkbox:checked').forEach(function (checkbox) {
        if (checkbox.dataset.idlsp) {
            selectedCategories.push(checkbox.dataset.idlsp);
        }
        if (checkbox.dataset.idth) {
            selectedBrands.push(checkbox.dataset.idth);
        }
        if (checkbox.dataset.idkt) {
            selectedSizes.push(checkbox.dataset.idkt);
        }
        if (checkbox.dataset.idm) {
            selectedColor.push(checkbox.dataset.idm);
        }
        if (checkbox.dataset.priceRange) {
            selectedPriceRanges.push(checkbox.dataset.priceRange.split(',').map(Number)); // Chuyển khoảng giá thành mảng số
        }
    });

    // Lọc sản phẩm
    products.forEach(function (product) {
        let productCategory = product.getAttribute('data-idlsp');
        let productBrand = product.getAttribute('data-idth');
        let productSizes = product.getAttribute('data-idkt').split(',');
        let productColor = product.getAttribute('data-idm').split(',');
        let productPrice = parseInt(product.getAttribute('data-price'));

        let matchCategory = selectedCategories.length === 0 || selectedCategories.includes(productCategory);
        let matchBrand = selectedBrands.length === 0 || selectedBrands.includes(productBrand);
        let matchSize = selectedSizes.length === 0 || selectedSizes.some(size => productSizes.includes(size));
        let matchColor = selectedColor.length === 0 || selectedColor.some(color => productColor.includes(color));

        // Kiểm tra giá nếu có khoảng giá được chọn
        let matchPrice = selectedPriceRanges.length === 0 || selectedPriceRanges.some(function (range) {
            return productPrice >= range[0] && productPrice <= range[1];
        });

        // Kiểm tra tất cả các điều kiện
        if (matchCategory && matchBrand && matchSize && matchColor && matchPrice) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}


