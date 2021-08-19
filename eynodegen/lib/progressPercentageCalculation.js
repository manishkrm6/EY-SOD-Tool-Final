
exports.getProgressSummary = (data) => {
    
    //console.log(data);
    

    let sum = 0;
    let percentage = 0;

    //console.log("Length "+ data.length);

    // ===== Card 1 === 
    const analysis_detail = data[0].is_completed;
    const upload_from_file = data[1].is_completed;

    sum = analysis_detail + upload_from_file ;
    percentage = parseFloat((sum * 100)/2).toFixed(2);

    const extract_status = percentage;
    //console.log("Extract Status "+extract_status);

    // ====== Card 2 =====
    const select_user = data[2].is_completed;
    const finalize_rule = data[3].is_completed;
    const start_analysis = data[4].is_completed == 1 ? 1 : 0;

    sum = select_user + finalize_rule + start_analysis;
    percentage = parseFloat((sum * 100)/3).toFixed(2);
    
    const configure_status = percentage;
    //console.log("Configure Status "+configure_status);

    // ======== Card 3 ========
    
    const analysis_prep = data[5].is_completed == 1 ? 1 : 0;
    const role_analysis = data[6].is_completed == 1 ? 1 : 0;
    const user_analysis = data[7].is_completed == 1 ? 1 : 0;
    const root_cause = data[8].is_completed == 1 ? 1 : 0;

    sum = analysis_prep + role_analysis + user_analysis + root_cause;
    percentage = parseFloat((sum * 100)/4).toFixed(2);

    const analysis_status = percentage;

    //console.log("Analysis Status "+analysis_status);

    // ======= Card 4 =======
    
    const dashboard = data[9].is_completed == 1 ? 1 : 0;
    //const report = data[10].is_completed == 1 ? 1 : 0;

    //sum = dashboard + report;

    sum = dashboard;

    percentage = parseFloat((sum * 100)/1).toFixed(2);
    const status_all_reports = percentage;

    //console.log("Reports Status "+status_all_reports);

    sum = parseFloat(extract_status) + parseFloat(configure_status) + parseFloat(analysis_status) + parseFloat(status_all_reports);
    
    percentage =  parseFloat((sum * 100)/400).toFixed(2);

    const overall_status = percentage;

     //console.log("Overall Status "+overall_status);

    return {
        "overall_status": overall_status,
        "extract_status": parseInt(extract_status),
        "configure_status": parseInt(configure_status),
        "analysis_status": parseInt(analysis_status),
        "status_all_reports": parseInt(status_all_reports),
        "chbx_start_analysis": start_analysis,
        "chbx_analysis_prep": analysis_prep,
        "chbx_role_analysis": role_analysis,
        "chbx_user_analysis": user_analysis,
        "chbx_root_cause_analysis": root_cause,
        "chbx_dashbaord": dashboard,
        //"chbx_reports": report

    };

    


};