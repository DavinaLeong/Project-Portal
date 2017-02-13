var UrlField = React.createClass({
    getInitialState: function()
    {
        return {
            url: this.props.url,
            use_https: this.props.use_https
        }
    },
    onUrlChange: function(event)
    {
        this.setState({
            url: event.target.value
        });
    },
    onUseHttpsChange: function(event)
    {
        this.setState({
            use_https: event.target.checked
        });
    },
    render: function ()
    {
        var http_text = this.state.use_https == 1 ? 'https://' : 'http://';

        return (
            <div>
                <div className="form-group">
                    <label className="control-label col-md-2" htmlFor="url">URL <span className="text-danger">*</span></label>
                    <div className="col-md-10">
                        <div className="input-group">
                            <span className="input-group-addon"><b>{http_text}</b></span>
                            <input className="form-control" type="text" id="url" name="url" value={this.state.url} required onChange={this.onUrlChange} data-parsley-errors-container="#url_errors" />
                            <span className="input-group-addon">
                                <input type="checkbox" id="use_https" name="use_https" value="1" checked={this.state.use_https == 1 ? 'checked' : '' } onChange={this.onUseHttpsChange} data-parsley-errors-container="#url_errors" /> Use HTTPS
                            </span>
                        </div>
                        <p id="url_errors">&nbsp;</p>
                        <p className="help-block">Exclude 'http://' from url.</p>
                    </div>
                </div>
            </div>
        );
    }
});