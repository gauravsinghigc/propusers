<?php


if (isset($_POST['CreateRewards'])) {

  $user_rewards = [
    "RewardRefNo" => SECURE($_POST['RewardRefNo'], "d"),
    "RewardName" => $_POST['RewardName'],
    "RewardMainUserId" => $_POST['RewardMainUserId'],
    "RewardAttachedCreative" => UPLOAD_FILES("../storage/rewards/" . SECURE($_POST['RewardRefNo'], "d") . "/", "null", "Reward_", "RewardAttachedCreative"),
    "RewardCreatedAt" => CURRENT_DATE_TIME,
    "RewardReceiveDate" => $_POST['RewardReceiveDate'],
    "RewardCreatedBy" => LOGIN_UserId,
    "RewardMessage" => SECURE($_POST['RewardMessage'], "e"),
    "RewardStatus" => "NEW"
  ];

  RequestHandler(INSERT("user_rewards", $user_rewards), [
    "true" => "Reward details are saved successfully!",
    "false" => "Unable to save reward details at the moment!"
  ]);

  //update reward details
} elseif (isset($_POST['UpdateRewards'])) {
  $RewardsId = SECURE($_POST['RewardsId'], "d");

  $user_rewards = [
    "RewardName" => $_POST['RewardName'],
    "RewardMainUserId" => $_POST['RewardMainUserId'],
    "RewardUpdatedAt" => CURRENT_DATE_TIME,
    "RewardReceiveDate" => $_POST['RewardReceiveDate'],
    "RewardUpdatedBy" => LOGIN_UserId,
    "RewardMessage" => SECURE($_POST['RewardMessage'], "e")
  ];

  $RewardAttachedCreative = UPLOAD_FILES("../storage/rewards/" . SECURE($_POST['RewardRefNo'], "d") . "/", "null", "Reward_", "RewardAttachedCreative");

  if ($RewardAttachedCreative != null) {
    $Update = UPDATE("UPDATE user_rewards SET RewardAttachedCreative='$RewardAttachedCreative' where RewardsId='$RewardsId'");
  }

  RequestHandler(UPDATE_DATA("user_rewards", $user_rewards, "RewardsId='$RewardsId'"), [
    "true" => "Reward details are updated successfully!",
    "false" => "Unable to update reward details at the moment!"
  ]);

  //remove reward controller
} elseif (isset($_GET['remove_reward_record'])) {
  DeleteReqHandler(
    "remove_reward_record",
    [
      "user_rewards" => "RewardsId='" . SECURE($_GET['RewardsId'], "d") . "'",
    ],
    [
      "true" => "Rewards details are deleted successfully",
      "false" => "Unable to delete reward details at the moment"
    ]
  );

  //mark as read
} elseif (isset($_POST['MarkAsRead'])) {
  $RewardsId  = SECURE($_POST['RewardsId'], "d");

  $user_rewards = [
    "RewardStatus" => "Read",
  ];
  $Response = UPDATE_DATA("user_rewards", $user_rewards, "RewardsId='$RewardsId'");
  RequestHandler($Response, [
    "true" => "Rewards details are updated as read successfully!",
    "false" => "Unable to update reward details as read at the moment"
  ]);
}
