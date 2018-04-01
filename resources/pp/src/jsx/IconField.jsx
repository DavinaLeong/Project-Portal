var IconField = React.createClass
({
    getInitialState: function()
    {
        return {
            icon_name: this.props.icon_name
        };
    },
    onIconFieldChange: function(event)
    {
        this.setState({
            icon_name: event.target.value
        });
    },
    render: function ()
    {
        var icon = this.state.icon_name + ' fa-fw';
        var asterisk = this.props.required ? <span className="text-danger">*</span> : '';
        return (
            <div className="form-group">
                <label className="control-label col-md-2"
                       htmlFor={this.props.field_name}>Icon {asterisk}</label>
                <div className="col-md-10">
                    <div className="input-group">
                        <input className="form-control" type="text" id={this.props.field_name} name={this.props.field_name}
                               value={this.state.icon_name} required={this.props.required ? 'required' : ''} onChange={this.onIconFieldChange} />
                        <span className="input-group-addon"><span className="text-muted"><small>({icon})</small> <i className={icon}></i></span></span>
                    </div>
                    <p className="help-block"><a href="https://fontawesome.com/icons/" target="_blank">Font-Awesome Icon Reference</a></p>
                </div>
            </div>
        );
    }
});