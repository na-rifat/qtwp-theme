(function () {
    const { addAction } = window.cf.hooks;

    addAction("carbon-fields.init", "carbon-fields/metaboxes", () => {
        const { select } = window.cf.vendor["@wordpress/data"];
        const fields = select("carbon-fields/metaboxes").getFieldsByContainerId(
            "carbon_fields_container_post_meta"
        );

        const textFieldValue = fields.find(
            (field) => field.base_name === "crb_text"
        );
        console.log(fields);
    });
})();

(function ($) {
    $(document).ready(function () {
        const admin = {
            init() {
                this.handleResourceConditions();
            },
            handleResourceConditions() {},
        };

        admin.init();
    });
})(jQuery);
