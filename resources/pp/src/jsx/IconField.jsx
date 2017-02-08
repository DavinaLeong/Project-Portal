var IconField = React.createClass
({
    getInitialState: function()
    {
        return {
            platform_icon: this.props.platform_icon
        };
    },
    onIconFieldChange: function(event)
    {
        this.setState({
            platform_icon: event.target.value
        });
    },
    render: function ()
    {
        var icon = 'fa ' + this.state.platform_icon + ' fa-fw';
        return (
            <div className="form-group">
                <label className="control-label col-md-2" htmlFor="platform_icon">Icon <span className="text-danger">*</span></label>
                <div className="col-md-10">
                    <div className="input-group">
                        <input className="form-control" type="text" id="platform_icon" name="platform_icon"
                               value={this.state.platform_icon} required onChange={this.onIconFieldChange} />
                        <span className="input-group-addon"><small>({icon})</small> <i className={icon}></i></span>
                    </div>
                    <p className="help-block"><a href="http://fontawesome.io/icons/" target="_blank">Font-Awesome Icon Reference</a></p>
                </div>
            </div>
        );
    }
});