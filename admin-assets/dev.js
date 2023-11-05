(function ($) {
    const dev = {
        init() {
            this.dur = 600;
            this.parent = $(`.dev-tools`);
            this.console_screen = this.parent.find(`.dev-console`);

            this.console.parent = this;

            this.console.log("dev tools started");

            this.sendOperation();
        },
        console: {
            success(msg) {
                this.parent.console_screen.prepend(
                    `<li class="success">${msg}</li>`
                );
            },
            error(msg) {
                this.parent.console_screen.prepend(
                    `<li class="error">${msg}</li>`
                );
            },
            log(msg) {
                this.parent.console_screen.prepend(`<li>${msg}</li>`);
            },
        },
        sendOperation() {
            let me = this;
            this.parent.find(`.btn-grp a`).on(`click`, function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: nh.ajax_url,
                    data: {
                        action: `nh_dev_opration`,
                        operation: $(this).data(`operation`),
                    },
                    dataType: "JSON",
                    success: function (res) {
                        console.log(res);
                        if (res.success) {
                            me.console.success(res.data.msg);
                        } else {
                            me.console.error(res.data.msg);
                        }
                    },
                    error: () => me.console.error(`Server failed to connect.`),
                });
            });
        },
    };

    dev.init();
})(jQuery);
