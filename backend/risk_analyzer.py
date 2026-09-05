def get_risk_level(score):

    if score >= 80:
        return "CRITICAL"

    elif score >= 60:
        return "HIGH"

    elif score >= 40:
        return "MEDIUM"

    return "LOW"


def get_recommendation(hazard, failed_barriers):

    recommendations = {

        "Line of Fire":
            "Establish exclusion zones and prevent personnel from entering the line of fire.",

        "Electrical":
            "Verify isolation and implement Lock-Out/Tag-Out before work begins.",

        "Confined Space":
            "Perform atmospheric testing and verify confined-space entry controls.",

        "Working at Height":
            "Verify fall protection, access equipment and edge protection.",

        "Chemical Exposure":
            "Verify chemical controls, PPE and emergency response arrangements.",

        "Machine / Mechanical":
            "Verify machine guarding and energy isolation before maintenance."
    }

    action = recommendations.get(
        hazard,
        "Review the hazard and strengthen the required safety barriers."
    )

    if failed_barriers:

        action += " Priority barrier checks: " + ", ".join(failed_barriers) + "."

    return action


def generate_risk_result(analysis):

    score = analysis["sif_score"]

    return {
        "score": score,
        "risk_level": get_risk_level(score),
        "recommendation": get_recommendation(
            analysis["hazard"],
            analysis["failed_barriers"]
        )
    }