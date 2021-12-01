function mostrarPDF(url) {
    let es_chrome = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
    if (es_chrome) {
        var iframe = document.createElement("iframe");
        iframe.style.display = "none";
        iframe.src = url;
        document.body.appendChild(iframe);
        iframe.focus();
        iframe.contentWindow.print();
        console.log(iframe.contentWindow)
    } else {
        var win = window.open(url, "_blank");
        win.focus();
    }
}
