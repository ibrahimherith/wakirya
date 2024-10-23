$(document).ready(function () {
  // alertify.set("notifier", "position", "top-right");

  $(document).on("click", ".increment", function () {
    updateQuantity($(this), 1);
  });

  $(document).on("click", ".decrement", function () {
    updateQuantity($(this), -1);
  });

  function updateQuantity(button, change) {
    var $quantityInput = button.closest(".qtyBox").find(".qty");
    var productId = button.closest(".qtyBox").find(".prodId").val();
    var currentValue = parseInt($quantityInput.val());

    if (!isNaN(currentValue) && !(currentValue <= 1 && change < 0)) {
      var qtyVal = currentValue + change;
      $quantityInput.val(qtyVal);

      sendQuantityUpdate(productId, qtyVal, "orders-code.php");
      sendQuantityUpdate(productId, qtyVal, "loans-code.php");
      sendQuantityUpdate(productId, qtyVal, "preorders-code.php");
    }
  }

  function sendQuantityUpdate(prodId, qty, url) {
    $.ajax({
      type: "POST",
      url: url,
      data: {
        productIncDec: true,
        product_id: prodId,
        quantity: qty,
      },
      success: function (response) {
        var res = JSON.parse(response);

        $("#productArea").load(" #productContent");

        if (res.status == 200) {
          // alertify.success(res.message);
        } else {
          // alertify.error(res.message);
        }
      },
    });
  }

  // PROCEED TO PLACE  ORDER  BUTTON
  $(document).on("click", ".proceedToPlace", function () {
    proceedToPlace("orders-code.php", "order-summary.php");
  });

  $(document).on("click", ".proceedToPlaceLoan", function () {
    proceedToPlace("loans-code.php", "loan-summary.php");
  });

  $(document).on("click", ".proceedToPlacePreorder", function () {
    proceedToPlace("preorders-code.php", "preorder-summary.php");
  });

  function proceedToPlace(url, redirectUrl) {
    var cname = $("#jina").val();
    var amount_paid = $("#amount_paid").val();
    var destination = $("#destination").val();
    var comment = $("#comment").val();

    if (amount_paid == "" || !$.isNumeric(amount_paid)) {
      swal("Weka Kiasi Alicholipia", "", "warning");
      return false;
    }

    if (cname == "") {
      swal("Jina la Mteja", "", "warning");
      return false;
    }

    // Data to be sent in the AJAX request
    var data = {
      proceedToPlaceBtn: true,
      cname: cname,
      destination: destination,
      amount_paid: amount_paid,
      comment: comment,
    };

    // AJAX request
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          window.location.href = redirectUrl;
        } else if (res.status == 404) {
          swal(res.message, "", res.status_type, {
            buttons: {
              catch: {
                text: "Add",
                value: "catch",
              },
              cancel: "Cancel",
            },
          }).then((value) => {
            switch (value) {
              case "catch":
                $("#c_name").val(cname);
                // $("#c_phone").val(cphone);
                $("#addCustomerModal").modal("show");
                break;
              default:
            }
          });
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  }

  // ADD CUSTOMERS TO CUSTOMER TABLE
  $(document).on("click", ".saveCustomer", function () {
    saveCustomer("orders-code.php");
  });

  $(document).on("click", ".saveCustomerLoan", function () {
    saveCustomer("loans-code.php");
  });

  $(document).on("click", ".saveCustomerPreorder", function () {
    saveCustomer("preorders-code.php");
  });

  function saveCustomer(url) {
    var c_name = $("#c_name").val();
    var c_phone = $("#c_phone").val();
    // var c_email = $("#c_email").val();

    if (c_name != "") {
      var data = {
        saveCustomerBtn: true,
        name: c_name,
        phone: c_phone,
        // email: c_email,
      };

      // AJAX request to the provided URL
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (response) {
          var res = JSON.parse(response);

          if (res.status == 200) {
            swal(res.message, "", res.status_type);
            $("#addCustomerModal").modal("hide");
          } else if (res.status == 422) {
            swal(res.message, "", res.status_type);
          } else {
            swal(res.message, "", res.status_type);
          }
        },
      });
    } else {
      swal("Please Fill required fields", "", "warning");
    }
  }

  // SAVE ORDER
  $(document).on("click", "#saveOrder", function () {
    saveOrder("orders-code.php");
  });

  $(document).on("click", "#saveLoan", function () {
    saveOrder("loans-code.php");
  });

  $(document).on("click", "#savePreorder", function () {
    saveOrder("preorders-code.php");
  });

  function saveOrder(url) {
    $.ajax({
      type: "POST",
      url: url,
      data: {
        saveOrder: true,
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.status == 200) {
          // swal(res.message, res.message, res.status_type);
          $("#orderPlaceSuccessMessage").text(res.message);
          $("#orderSuccessModal").modal("show");
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  }
});

function printMyBillingArea() {
  var divContents = document.getElementById("myBillingArea").innerHTML;
  var a = window.open("", "");
  a.document.write("<html><title>Wakirya</title>");
  a.document.write('<body style="font-family: fangsong;">');
  a.document.write(divContents);
  a.document.write("</body></html>");
  a.document.close();
  a.print();
}

window.jsPDF = window.jspdf.jsPDF;
var docPDF = new jsPDF();

function downloadPDF(invoiceNo) {
  var elementHTML = document.querySelector("#myBillingArea");
  docPDF.html(elementHTML, {
    callback: function () {
      docPDF.save(invoiceNo + ".pdf");
    },
    x: 15,
    y: 15,
    width: 170,
    windowWidth: 650,
  });
}

// HEHEHEHEHHEHEHEH
