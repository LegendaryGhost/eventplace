import React from "react";

const Button = (props) => {
  return (
    <>
      <button
        type={props.type ?? "button"}
        disabled={props.disabled}
        onClick={props.onClick}
        className={
          `btn btn-${props.color ?? "default border "} ` + props.className
        }
      >
        {props.value}
      </button>
    </>
  );
};

export default Button;
